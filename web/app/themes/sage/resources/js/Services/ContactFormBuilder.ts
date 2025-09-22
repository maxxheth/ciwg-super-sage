import type { EmailRequest, EmailResponse } from '~/email-types';
import { EmailService } from './EmailService';
import * as v from 'valibot';
import Swal from 'sweetalert2'; // Import SweetAlert2

/**
 * Contact form builder for configurable form validation and submission
 */
export class ContactFormBuilder {
  private formSelector: string;
  private fieldSchemas: Map<string, any> = new Map();
  private successCallback?: (response: EmailResponse) => void;
  private errorCallback?: (error: Error) => void;
  private emailService: EmailService;
  private customEmailDataFormatter?: (formData: FormData) => Omit<EmailRequest, '_wpnonce'>;
  private defaultRecipient: string = 'contact@example.com';

  constructor(emailService: EmailService, formSelector: string) {
    this.formSelector = formSelector;
    this.emailService = emailService;

    // Add default field schemas (assuming 'name' might not always exist, adjust if needed)
    // Example: Use first_name and last_name if they exist in your form
    this.addField(
      'first_name',
      v.pipe(
        v.string('First name must be a string'),
        v.minLength(1, 'First name is required'),
        v.maxLength(50, 'First name cannot exceed 50 characters'),
      ),
    );
    this.addField(
      'last_name',
      v.pipe(
        v.string('Last name must be a string'),
        v.minLength(1, 'Last name is required'),
        v.maxLength(50, 'Last name cannot exceed 50 characters'),
      ),
    );
    this.addField(
      'email',
      v.pipe(
        v.string(''),
        v.email('Please enter a valid email address'),
        v.minLength(5, 'Email is required'),
      ),
    );
    this.addField(
      'message',
      v.pipe(
        v.string('Message must be a string'),
        v.minLength(10, 'Message must be at least 10 characters'),
        v.maxLength(1000, 'Message cannot exceed 1000 characters'),
      ),
    );
    // Add optional phone validation if needed
    this.addField(
      'phone',
      v.optional(
        v.pipe(
          v.string('Phone must be a string'),
          v.regex(/^[\d\s()+-]*$/, 'Invalid phone number format'), // Basic format check
        ),
      ),
    );
    // Add optional division validation if needed
    this.addField('division', v.optional(v.string('Division selection is required')));
  }

  /**
   * Add a field with its validation schema
   */
  public addField(fieldName: string, schema: any): this {
    this.fieldSchemas.set(fieldName, schema);
    return this;
  }

  /**
   * Remove a field validation schema
   */
  public removeField(fieldName: string): this {
    this.fieldSchemas.delete(fieldName);
    return this;
  }

  /**
   * Set success callback
   */
  public onSuccess(callback: (response: EmailResponse) => void): this {
    this.successCallback = callback;
    return this;
  }

  /**
   * Set error callback
   */
  public onError(callback: (error: Error) => void): this {
    this.errorCallback = callback;
    return this;
  }

  /**
   * Set a custom email data formatter function
   */
  public setEmailDataFormatter(
    formatter: (formData: FormData) => Omit<EmailRequest, '_wpnonce'>,
  ): this {
    this.customEmailDataFormatter = formatter;
    return this;
  }

  /**
   * Set default recipient email
   */
  public setDefaultRecipient(email: string): this {
    this.defaultRecipient = email;
    return this;
  }

  /**
   * Build validation schema and attach event handler to form
   */
  public build(): void {
    const form = document.querySelector<HTMLFormElement>(this.formSelector);

    if (!form) {
      console.error(`Form not found with selector: ${this.formSelector}`);
      return;
    }

    // Create combined validation schema from all fields
    const schemaObject: Record<string, any> = {};
    this.fieldSchemas.forEach((schema, fieldName) => {
      // Only add schema if the field actually exists in the form
      if (form.querySelector(`[name="${fieldName}"]`)) {
        schemaObject[fieldName] = schema;
      }
    });

    const formSchema = v.object(schemaObject);

    // Store original button text outside the handler to avoid issues in finally block
    const submitButton = form.querySelector<HTMLButtonElement | HTMLInputElement>(
      'button[type="submit"], input[type="submit"]',
    );
    let originalButtonText = 'Submit'; // Default
    if (submitButton) {
      originalButtonText =
        submitButton.textContent || (submitButton as HTMLInputElement).value || 'Submit';
    }

    // Attach submit event handler
    form.addEventListener('submit', async (event) => {
      const isCancelable = event.cancelable;
      console.log({ isCancelable });
      event.preventDefault();
      console.log('Submit event triggered, preventDefault called'); // Debugging line

      // throw Error("Test error");

      // Clear previous validation errors shown by handleFormError
      const previousErrors = form.querySelectorAll('.form-error-message');
      previousErrors.forEach((el) => el.remove());

      const formData = new FormData(form);

      // Create values object for validation based on actual schema keys
      const formValues: Record<string, any> = {};
      Object.keys(schemaObject).forEach((fieldName) => {
        formValues[fieldName] = formData.get(fieldName) as string;
      });

      // Check if test mode is enabled via data attribute
      const isTestMode = form.dataset.test === 'true';

      try {
        // Validate form data
        v.parse(formSchema, formValues);

        // Prepare email data - either use custom formatter or default
        let emailData: Omit<EmailRequest, '_wpnonce'>;

        if (this.customEmailDataFormatter) {
          emailData = this.customEmailDataFormatter(formData);
        } else {
          // Default email data preparation - use specific fields
          const firstName = formValues.first_name || '';
          const lastName = formValues.last_name || '';
          const fullName = `${firstName} ${lastName}`.trim();

          emailData = {
            to: form.dataset.recipient || this.defaultRecipient,
            subject: `New contact form submission from ${fullName || 'website'}`,
            message: this.emailService.createEmailTemplate({
              // Pass specific fields to template
              name: fullName,
              email: formValues.email || '',
              phone: formValues.phone || '', // Add phone if exists
              division: formValues.division || '', // Add division if exists
              message: formValues.message || '',
            }),
            from_name: `${fullName || 'Website Contact'}`, // More specific from name
            from_email: formValues.email, // Use validated email
            reply_to: formValues.email, // Use validated email
            honeypot: (formData.get('honeypot') as string) || '',
          };
        }

        // Add test mode flag if enabled
        if (isTestMode) {
          emailData.test_mode = 'true';
        }

        // Display loading state
        if (submitButton) {
          if (submitButton instanceof HTMLButtonElement) {
            submitButton.textContent = 'Sending...';
          } else if (submitButton instanceof HTMLInputElement) {
            submitButton.value = 'Sending...';
          }
          submitButton.setAttribute('disabled', 'disabled');
        }

        // Send the email
        const response = await this.emailService.sendEmail(emailData);

        // --- SweetAlert2 Success Notification ---
        let successMessage = response.message || 'Thank you for your message!';
        if (isTestMode && response.test_mode) {
          successMessage += ' (TEST MODE)';
        }
        console.log({ successCallback: this.successCallback });
        await Swal.fire({
          title: 'Success!',
          text: successMessage,
          icon: 'success',
          confirmButtonText: 'OK',
          timer: 5000,
          timerProgressBar: true,
          returnFocus: false,
        });
        // --- End SweetAlert2 ---

        // Reset form on success
        form.reset();

        // Call success callback if provided

        if (this.successCallback) {
          this.successCallback(response);
        }
        return;
      } catch (error) {
        // Handle validation errors (shows inline) or general errors (shows toast)
        this.handleFormError(form, error);
      } finally {
        // Reset submit button state using the stored original text
        if (submitButton) {
          if (submitButton instanceof HTMLButtonElement) {
            submitButton.textContent = originalButtonText;
          } else if (submitButton instanceof HTMLInputElement) {
            submitButton.value = originalButtonText;
          }
          submitButton.removeAttribute('disabled');
        }
        return;
      }
    });
  }

  /**
   * Handle form submission errors
   */
  private handleFormError(form: HTMLFormElement, error: unknown): void {
    if (v.isValiError(error)) {
      // Clear previous error messages shown by this handler
      const errorMessages = form.querySelectorAll('.form-error-message');
      errorMessages.forEach((el) => el.remove());

      // Display validation errors under each field
      const issues = error.issues || [];
      let firstErrorMessage = 'Please correct the errors below.'; // Default message
      for (const issue of issues) {
        const fieldName = issue.path?.[0]?.key as string;
        if (fieldName) {
          const fieldElement = form.querySelector(`[name="${fieldName}"]`);
          if (fieldElement) {
            const errorElement = document.createElement('div');
            errorElement.className = 'form-error-message'; // Keep class for potential styling/clearing
            errorElement.textContent = issue.message;
            errorElement.style.color = 'red'; // Basic styling
            errorElement.style.fontSize = '0.8rem';
            errorElement.style.marginTop = '0.25rem';
            fieldElement.parentNode?.insertBefore(errorElement, fieldElement.nextSibling);
            if (firstErrorMessage === 'Please correct the errors below.') {
              firstErrorMessage = issue.message; // Use the first specific error for the toast
            }
          }
        }
      }
      // --- SweetAlert2 Validation Error Notification ---
      Swal.fire({
        title: 'Validation Error',
        text: firstErrorMessage, // Show the first specific error
        icon: 'error',
        confirmButtonText: 'OK',
        timer: 5000,
        timerProgressBar: true,
        returnFocus: false,
      });
      // --- End SweetAlert2 ---
    } else {
      // Handle API or other general errors with SweetAlert2
      const errorMessage = error instanceof Error ? error.message : 'An unknown error occurred';

      // --- SweetAlert2 General Error Notification ---
      Swal.fire({
        title: 'Error',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: 'OK',
        timer: 5000,
        timerProgressBar: true,
        returnFocus: false,
      });
      // --- End SweetAlert2 ---

      // Call error callback if provided
      if (this.errorCallback && error instanceof Error) {
        this.errorCallback(error);
      }

      console.error('Form submission error:', error);
    }
  }
}

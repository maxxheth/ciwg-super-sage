import type { EmailRequest, EmailResponse, ValidationErrors } from '~/email-types';
import { ContactFormBuilder } from './ContactFormBuilder';

export class EmailService {
  private readonly apiEndpoint: string;
  private wpNonce: string;

  /**
   * Initialize the email service
   * @param apiEndpoint The WordPress REST API endpoint for mail
   * @param wpNonce WordPress security nonce (optional, will try to auto-detect)
   */
  constructor(apiEndpoint = '/wp-json/sage/v1/mail', wpNonce = '') {
    this.apiEndpoint = apiEndpoint;

    // 1. Try passed-in nonce
    let detectedNonce = wpNonce;

    // 2. Try global sageApiSettings
    if (!detectedNonce) {
      detectedNonce = (window as any).sageApiSettings?.nonce || '';
    }

    // 3. Try reading from the hidden input field as a fallback
    if (!detectedNonce) {
      const nonceInput = document.querySelector(
        'input[name="_wpnonce"]',
      ) as HTMLInputElement | null;
      if (nonceInput) {
        detectedNonce = nonceInput.value;
        console.log('EmailService: Nonce obtained from hidden input field.');
      }
    }

    this.wpNonce = detectedNonce;

    if (!this.wpNonce) {
      console.warn(
        'EmailService: WordPress nonce could not be found. API requests will likely fail.',
      );
    } else {
      // Optional: Log the nonce source for debugging
      // console.log(`EmailService: Using nonce: ${this.wpNonce.substring(0, 5)}... (Source: ${wpNonce ? 'param' : (window as any).sageApiSettings?.nonce ? 'global' : 'input'})`);
    }
  }

  /**
   * Set the WordPress nonce (e.g., if fetched dynamically later)
   * @param nonce The WordPress security nonce
   */
  setNonce(nonce: string): void {
    this.wpNonce = nonce;
    if (!this.wpNonce) {
      console.warn('EmailService: WordPress nonce was explicitly set to empty.');
    }
  }

  /**
   * Send an email using the WordPress REST API
   * @param emailData The email data to send
   * @returns Promise with the email response
   * @throws Error if validation fails or API returns an error
   */
  async sendEmail(emailData: Omit<EmailRequest, '_wpnonce'>): Promise<EmailResponse> {
    // Re-check nonce just before sending, in case it was set later via setNonce
    if (!this.wpNonce) {
      // Maybe try reading from input again if it wasn't found initially
      const nonceInput = document.querySelector(
        'input[name="_wpnonce"]',
      ) as HTMLInputElement | null;
      if (nonceInput) {
        this.wpNonce = nonceInput.value;
        console.log('EmailService: Nonce obtained from hidden input field just before sending.');
      } else {
        throw new Error('Cannot send email: WordPress nonce is missing.');
      }
    }

    // Validate the email data
    const validationErrors = this.validateEmailData(emailData as EmailRequest);
    if (validationErrors.length > 0) {
      const errorMessages = validationErrors
        .map((error) => `${error.field}: ${error.message}`)
        .join('; ');
      throw new Error(`Email validation failed: ${errorMessages}`);
    }

    try {
      // Convert to FormData and send
      const formData = this.convertToFormData(emailData as EmailRequest);
      return await this.sendRequest(formData);
    } catch (error) {
      // Re-throw with a clearer message
      if (error instanceof Error) {
        throw new Error(`Failed to send email: ${error.message}`);
      }
      throw error;
    }
  }

  /**
   * Validate the email data for required fields and format
   * @param data The email data to validate
   * @returns Array of validation errors (empty if valid)
   */
  // Make _wpnonce optional in validation as it's not strictly needed here anymore
  private validateEmailData(
    data: Omit<EmailRequest, '_wpnonce'> & { _wpnonce?: string },
  ): ValidationErrors[] {
    const errors: ValidationErrors[] = [];

    // Check required fields
    if (!data.to) {
      errors.push({ field: 'to', message: 'Recipient email is required' });
    } else if (!this.isValidEmail(data.to)) {
      errors.push({ field: 'to', message: 'Invalid recipient email format' });
    }

    if (!data.subject) {
      errors.push({ field: 'subject', message: 'Subject is required' });
    } else if (data.subject.length > 200) {
      errors.push({
        field: 'subject',
        message: 'Subject cannot exceed 200 characters',
      });
    }

    if (!data.message) {
      errors.push({ field: 'message', message: 'Message content is required' });
    }

    // Validate optional email fields if present
    if (data.from_email && !this.isValidEmail(data.from_email)) {
      errors.push({
        field: 'from_email',
        message: 'Invalid sender email format',
      });
    }

    if (data.reply_to && !this.isValidEmail(data.reply_to)) {
      errors.push({
        field: 'reply_to',
        message: 'Invalid reply-to email format',
      });
    }

    // Validate CC addresses
    if (data.cc) {
      const ccEmails = Array.isArray(data.cc) ? data.cc : [data.cc];
      ccEmails.forEach((email, index) => {
        if (!this.isValidEmail(email)) {
          errors.push({
            field: `cc[${index}]`,
            message: `Invalid CC email format: ${email}`,
          });
        }
      });
    }

    // Validate BCC addresses
    if (data.bcc) {
      const bccEmails = Array.isArray(data.bcc) ? data.bcc : [data.bcc];
      bccEmails.forEach((email, index) => {
        if (!this.isValidEmail(email)) {
          errors.push({
            field: `bcc[${index}]`,
            message: `Invalid BCC email format: ${email}`,
          });
        }
      });
    }

    // Validate attachments
    if (data.attachments) {
      const files = Array.isArray(data.attachments) ? data.attachments : [data.attachments];

      files.forEach((file, index) => {
        // Check file size (10MB limit)
        if (file.size > 10 * 1024 * 1024) {
          errors.push({
            field: `attachments[${index}]`,
            message: `File ${file.name} exceeds 10MB limit`,
          });
        }

        // Check file type (basic security check)
        const fileExtension = file.name.split('.').pop()?.toLowerCase();
        const disallowedExtensions = ['exe', 'php', 'js', 'bat', 'cmd', 'vbs', 'sh'];

        if (fileExtension && disallowedExtensions.includes(fileExtension)) {
          errors.push({
            field: `attachments[${index}]`,
            message: `File type .${fileExtension} is not allowed`,
          });
        }
      });
    }

    return errors;
  }

  /**
   * Convert email data to FormData for submission
   * @param data The email data to convert
   * @returns FormData object ready for submission
   */
  // Ensure _wpnonce is not added here
  private convertToFormData(data: Omit<EmailRequest, '_wpnonce'>): FormData {
    const formData = new FormData();

    // Process all fields except _wpnonce
    const entries = Object.entries(data);

    for (const entry of entries) {
      const [key, value] = entry;
      // Skip undefined values and the nonce field
      if (value === undefined || key === '_wpnonce') continue;

      // Handle arrays (like cc, bcc, attachments)
      if (Array.isArray(value)) {
        if (key === 'attachments') {
          // Add each file with a unique key
          value.forEach((file, index) => {
            formData.append(`attachments[${index}]`, file);
          });
        } else {
          // For arrays like cc and bcc
          for (const item of value) {
            formData.append(`${key}[]`, item);
          }
        }
      } else if (value instanceof File) {
        // Handle single file attachment
        formData.append('attachments', value);
      } else {
        // Add other fields
        formData.append(key, String(value));
      }
    }

    return formData;
  }

  /**
   * Send the actual HTTP request
   * @param formData The form data to send
   * @returns Promise with the email response
   */
  private async sendRequest(formData: FormData): Promise<EmailResponse> {
    // Ensure nonce is available before creating headers
    if (!this.wpNonce) {
      // This should ideally be caught earlier, but as a safeguard:
      throw new Error('Cannot send request: WordPress nonce is missing.');
    }

    const headers: HeadersInit = {
      // Add the nonce header
      'X-WP-Nonce': this.wpNonce,
      // 'Accept': 'application/json', // Optional: Be explicit about expected response type
    };

    formData.append('_wpnonce', this.wpNonce); // Add nonce to form data

    const response = await fetch(this.apiEndpoint, {
      method: 'POST',
      headers: headers, // Use the headers object
      body: formData,
      credentials: 'same-origin', // Include cookies for WP nonce validation (still useful for login status)
    });

    // Try to parse JSON regardless of status code for more detailed errors
    let responseData: any;
    try {
      responseData = await response.json();
    } catch (e) {
      // If JSON parsing fails, use the raw text response
      responseData = { message: await response.text() };
    }

    if (!response.ok) {
      // Log the detailed error from WordPress if available
      console.error('API Error Status:', response.status, response.statusText);
      console.error('API Error Response:', responseData);
      // Use message from parsed JSON if available, otherwise construct a generic error
      throw new Error(responseData.message || `HTTP error ${response.status}`);
    }

    return responseData as EmailResponse;
  }

  /**
   * Validate email format
   * @param email Email address to validate
   * @returns True if valid, false otherwise
   */
  private isValidEmail(email: string): boolean {
    const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return emailRegex.test(email);
  }

  /**
   * Create an email template with specified data
   * @param templateData Data to inject into the template
   * @returns HTML string with the email content
   */
  createEmailTemplate(templateData: Record<string, string> = {}): string {
    // This is a simple example - in a real app, you might use a more sophisticated templating system
    const { name = '', message = '', email = '' } = templateData;

    return `
      <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #333;">New Message from Website</h2>
        <p><strong>From:</strong> ${this.escapeHtml(name)} (${this.escapeHtml(email)})</p>
        <div style="border-left: 4px solid #0073aa; padding-left: 15px; margin: 20px 0;">
          ${this.escapeHtml(message).replace(/\n/g, '<br>')}
        </div>
        <p style="color: #777; font-size: 12px;">
          This message was sent from your website contact form.
        </p>
      </div>
    `;
  }

  /**
   * Escape HTML to prevent XSS attacks in email templates
   * @param unsafe The unsafe string
   * @returns Escaped safe HTML string
   */
  private escapeHtml(unsafe: string): string {
    return unsafe
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  /**
   * Attach event handlers to a contact form for validation and submission
   * @param formSelector CSS selector for the form element
   * @param successCallback Optional callback function to execute on successful submission
   * @param errorCallback Optional callback function to execute on failed submission
   * @returns ContactFormBuilder instance for further configuration
   */
  public attachToContactForm(
    formSelector: string,
    successCallback?: undefined,
    errorCallback?: undefined,
  ): ContactFormBuilder {
    const builder = new ContactFormBuilder(this, formSelector);

    // Set callbacks if provided
    if (successCallback) {
      builder.onSuccess(successCallback);
    }

    if (errorCallback) {
      builder.onError(errorCallback);
    }

    return builder;
  }
}

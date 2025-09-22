// import { megaMenuInit } from './megaMenuInit';
import { animateOnScroll, processNumberAnimation } from './animateOnScroll';
import { hamburgerMenuInit } from './hamburgerMenuInit';
import { counterInit } from './counterInit';
import { SpinningLogo } from './UI/SpinningLogo';
import { vanillaParallaxInit } from './vanillaParallaxInit';
import initProjectGallerySlider from './projectGallerySliderInit';
import initPhotoSwipe from './photoSwipeInit';
import { EmailService } from './Services/EmailService';
import { ContactFormBuilder } from './Services/ContactFormBuilder';
import * as v from 'valibot';
// import { FeaturedProjectsDynamicCarousel } from './UI/FeaturedProjects';

// Define division options as a const object
const DIVISION_OPTIONS = {
  LANDSCAPING: 'landscaping',
  SOD: 'sod',
  CORPORATE: 'corporate',
  OTHER: 'other',
} as const;

// Create a type from the values
type Division = (typeof DIVISION_OPTIONS)[keyof typeof DIVISION_OPTIONS];

// Create a mapping for display labels
const DIVISION_LABELS: Record<Division, string> = {
  [DIVISION_OPTIONS.LANDSCAPING]: 'Landscaping Services',
  [DIVISION_OPTIONS.SOD]: 'Sod Farming',
  [DIVISION_OPTIONS.CORPORATE]: 'Corporate',
  [DIVISION_OPTIONS.OTHER]: 'Other',
};

// @ts-expect-error -- This is a workaround for the fact that we are using TypeScript and
// the glob import is not recognized by TypeScript.
import.meta.glob(['../images/**', '../fonts/**']);

// Initialize components
document.addEventListener('DOMContentLoaded', () => {
  // Initialize mega menu.
  // megaMenuInit();
  hamburgerMenuInit();
  counterInit();
  animateOnScroll();
  processNumberAnimation();

  // Initialize SpinningLogo component.
  const spinningLogoData = document.getElementById('spinningLogoData');

  const spinningLogoDataFromJson = JSON.parse(spinningLogoData?.textContent ?? '[]');

  console.log({ spinningLogoData });

  const mainLogo = spinningLogoDataFromJson?.mainLogo;

  new SpinningLogo('spinningLogosRoot', {
    styles: {
      container: 'grid place-content-center rounded-full bg-green-800 shadow-xl',
      outerCircle: 'relative grid place-items-center rounded-full shadow-md bg-white',
    },
    animations: {
      sequentialDisplay: true,
      displayOrder: 'clockwise',
      fadeInDuration: '0.8s',
      fadeOutDuration: '0.8s',
      displayDelay: '3s',
      // The outer circle still spins with the normal animation
      outerCircleAnimation: 'spin-clockwise',
      animationDuration: '60s',
    },
    icons: Object.values(spinningLogoDataFromJson.logos),
    centerLogo: {
      imagePath: mainLogo,
      className: 'bg-primary-light rounded-md hidden',
    },
    sizes: {
      // Main radius that controls overall size
      radiusToCenterOfIcons: {
        sm: 180, // Small screens
        md: 200, // Medium screens
        lg: 480, // Large screens
      },
      // Size of the icon containers
      iconWrapperWidth: {
        sm: 40,
        md: 40,
        lg: 100,
      },
      // Additional padding around the ring
      ringPadding: {
        sm: 8,
        md: 8,
        lg: 30,
      },
      // Center logo size
      centerLogoSize: {
        sm: 100,
        md: 100,
        lg: 300,
      },
    },
  });

  const initButtonNoOp = () => {
    const requestConsultationButton = document.getElementById('request-consultation');

    const noOpButtons = [requestConsultationButton];

    for (const button of noOpButtons) {
      if (!button) continue;

      button.addEventListener('click', (event: Event) => {
        event.preventDefault();
      });
    }
  };

  vanillaParallaxInit();
  initButtonNoOp();

  // Initialize project gallery slider
  initProjectGallerySlider();

  // Initialize PhotoSwipe galleries
  initPhotoSwipe();

  // Setup Intersection Observer
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    },
    { threshold: 0.1 },
  );

  // Observe all underline curves
  document.querySelectorAll('.underline-curve-container').forEach((curve) => {
    observer.observe(curve);
  });

  // Initialize email service
  const emailService = new EmailService();

  // Get WordPress nonce from the page if available
  const wpNonceElement = document.getElementById('wp_mail_nonce');
  if (wpNonceElement) {
    emailService.setNonce(wpNonceElement.textContent || '');
  }

  // Initialize contact form builder
  new ContactFormBuilder(emailService, '#careers-form')
    // Remove default name field since we're using first_name and last_name
    .removeField('name')
    // Add first name field validation
    .addField(
      'first_name',
      v.pipe(
        v.string('First name must be a string'),
        v.minLength(2, 'First name must be at least 2 characters'),
        v.maxLength(50, 'First name cannot exceed 50 characters'),
      ),
    )
    // Add last name field validation
    .addField(
      'last_name',
      v.pipe(
        v.string('Last name must be a string'),
        v.minLength(2, 'Last name must be at least 2 characters'),
        v.maxLength(50, 'Last name cannot exceed 50 characters'),
      ),
    )
    // Add phone field validation (optional but with format validation)
    .addField(
      'phone',
      v.optional(
        v.pipe(
          v.string('Phone must be a string'),
          v.minLength(7, 'Please enter a valid phone number'),
          v.maxLength(20, 'Phone number is too long'),
        ),
      ),
    )
    // Add division field validation using our enum values
    .addField(
      'division',
      v.pipe(
        v.string('Please select a division'),
        v.union(
          [v.literal('landscaping'), v.literal('sod'), v.literal('corporate'), v.literal('other')],
          'Please select a valid division',
        ),
      ),
    )
    // Format email with all form fields
    .setEmailDataFormatter((formData) => {
      const firstName = formData.get('first_name') as string;
      const lastName = formData.get('last_name') as string;
      const fullName = `${firstName} ${lastName}`.trim();
      const email = formData.get('email') as string;
      const phone = (formData.get('phone') as string) || 'Not provided';
      const division = formData.get('division') as Division;
      const message = formData.get('message') as string;

      // Get division label from our mapping
      const divisionLabel = division ? DIVISION_LABELS[division] : 'Not specified';

      return {
        to: 'info@edfx.co', // Set appropriate recipient email
        subject: `Job Application from ${fullName}`,
        message: `
          <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #016630;">New Job Application</h2>
            <p><strong>Applicant:</strong> ${fullName}</p>
            <p><strong>Email:</strong> ${email}</p>
            <p><strong>Phone:</strong> ${phone}</p>
            <p><strong>Division:</strong> ${divisionLabel}</p>
            <h3 style="color: #333;">Cover Letter / Message:</h3>
            <div style="border-left: 4px solid #016630; padding-left: 15px; margin: 20px 0;">
              ${message.replace(/\n/g, '<br>')}
            </div>
            <p style="color: #777; font-size: 12px;">
              This application was submitted from your website careers page.
            </p>
          </div>
        `,
        from_name: `${fullName} - Job Application`,
        from_email: email,
        reply_to: email,
        // Include honeypot field for spam detection
        honeypot: (formData.get('honeypot') as string) || '',
      };
    })
    // Set custom success callback
    .onSuccess((response) => {
      console.log('Job application submitted successfully!', response);
      // Scroll to top of form
      const form = document.querySelector('#careers-form');
      if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    })
    .build();

  // Initialize any other contact forms on the page
  const contactForms = document.querySelectorAll('form[id^="contact-form-"]');
  contactForms.forEach((form) => {
    if (form.id !== 'careers-form') {
      // Skip careers form as it's already initialized
      emailService.attachToContactForm(`#${form.id}`).build();
    }
  });

  // Initialize featured projects carousel

  // FeaturedProjectsDynamicCarousel('#featured-projects');
});

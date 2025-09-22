/**
 * Type representing the data structure for email requests to the WordPress API.
 */
export type EmailRequest = {
  /*
  *
   * The recipient email address
   * @required
   */
  to: string;

  /**
   * Email subject line
   * @required
   */
  subject: string;

  /**
   * Email body content (can contain HTML)
   * @required
   */
  message: string;

  /**
   * Sender's name to display in the "From" field
   * @optional
   */
  from_name?: string;

  /**
   * Sender's email address
   * @optional
   */
  from_email?: string;

  /**
   * Email address for recipients to reply to
   * @optional
   */
  reply_to?: string;

  /**
   * Carbon copy recipient email addresses
   * @optional
   */
  cc?: string | string[];

  /**
   * Blind carbon copy recipient email addresses
   * @optional
   */
  bcc?: string | string[];

  /**
   * WordPress nonce for security verification
   * @required
   */
  _wpnonce: string;

  /**
   * Honeypot field for spam detection (should be left empty)
   * @optional
   */
  honeypot?: string;

  /**
   * File attachments
   * @optional
   */
  attachments?: File | File[];

  /**
   * Test mode flag
   */
  test_mode?: boolean | string | undefined;
}

/**
 * Type representing the response from the email API
 */
export type EmailResponse = {
  /**
   * Whether the email was sent successfully
   */
  success: boolean;

  /**
   * Response message
   */
  message: string;

  /**
   * Test mode flag
   */
  test_mode?: boolean | string | undefined;
}

/**
 * Type errors for email requests
 */
export type ValidationErrors = {
  [key: string]: string;
}

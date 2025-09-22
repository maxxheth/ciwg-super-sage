<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use WP_Error;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class MailService
{
    /**
     * Whether the service is in test mode
     * 
     * @var bool
     */
    protected $testMode = false;
    
    /**
     * Stores the last test email for verification
     * 
     * @var array|null
     */
    protected $lastTestEmail = null;
    
    /**
     * Enable or disable test mode
     * 
     * @param bool $enabled
     * @return self
     */
    public function setTestMode(bool $enabled): self
    {
        $this->testMode = $enabled;
        return $this;
    }
    
    /**
     * Check if service is in test mode
     * 
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }
    
    /**
     * Get the last test email that was "sent"
     * 
     * @return array|null
     */
    public function getLastTestEmail(): ?array
    {
        return $this->lastTestEmail;
    }

    /**
     * Send an email using SMTP with PHPMailer
     *
     * @param  array  $data  Email data
     */
    public function send(array $data): bool|WP_Error
    {
        // Validate required fields
        if (empty($data['to']) || empty($data['subject']) || empty($data['message'])) {
            return new WP_Error(
                'missing_fields',
                __('Required email fields are missing.', 'sage'),
                ['status' => 400],
            );
        }

        // Prepare email parameters
        $to = $data['to'];
        $subject = $data['subject'];
        $message = $data['message'];
        $attachments = $data['attachments'] ?? [];
        
        // Handle test mode
        if ($this->testMode) {
            // Store the email for later verification
            $this->lastTestEmail = [
                'to' => $to,
                'subject' => $subject,
                'message' => $message,
                'headers' => $this->prepareHeaders($data), // Kept for test consistency
                'attachments' => $attachments,
                'timestamp' => current_time('mysql'),
            ];
            
            // Log the test email instead of sending it
            Log::info('Test email would have been sent', [
                'to' => $to,
                'subject' => $subject,
                'test_mode' => true,
            ]);
            
            return true;
        }

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST', 'smtp.privateemail.com');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
            $mail->Port = env('MAIL_PORT', 587);

            // Recipients
            if (! empty($data['from_name']) && ! empty($data['from_email'])) {
                $mail->setFrom($data['from_email'], $data['from_name']);
            } else {
                $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            }

            $mail->addAddress(is_array($to) ? $to[0] : $to); // PHPMailer handles multiple 'to' differently

            if (! empty($data['reply_to'])) {
                $mail->addReplyTo($data['reply_to']);
            }
            if (! empty($data['cc'])) {
                foreach ((array) $data['cc'] as $cc_email) {
                    $mail->addCC($cc_email);
                }
            }
            if (! empty($data['bcc'])) {
                foreach ((array) $data['bcc'] as $bcc_email) {
                    $mail->addBCC($bcc_email);
                }
            }

            // Attachments
            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = wp_strip_all_tags($message);

            $mail->send();

            return true;
        } catch (PHPMailerException $e) {
            Log::error('Failed to send email using PHPMailer', [
                'to' => $to,
                'subject' => $subject,
                'error' => $mail->ErrorInfo
            ]);

            return new WP_Error(
                'mail_error',
                __('Failed to send email. Please try again later.', 'sage'),
                ['status' => 500, 'error_message' => $mail->ErrorInfo]
            );
        }
    }

    /**
     * Prepare email headers
     *
     * @param  array  $data  Email data
     * @@return array
     */
    protected function prepareHeaders(array $data): array
    {
        $headers = [];

        // Set content type
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        // Set from name and email if provided
        if (! empty($data['from_name']) && ! empty($data['from_email'])) {
            $from_name = $data['from_name'];
            $from_email = $data['from_email'];
            $headers[] = "From: {$from_name} <{$from_email}>";
        }

        // Set reply-to if provided
        if (! empty($data['reply_to'])) {
            $reply_to = $data['reply_to'];
            $headers[] = "Reply-To: {$reply_to}";
        }

        // Set CC if provided
        if (! empty($data['cc'])) {
            $cc = (array) $data['cc'];
            foreach ($cc as $cc_email) {
                $headers[] = "Cc: {$cc_email}";
            }
        }

        // Set BCC if provided
        if (! empty($data['bcc'])) {
            $bcc = (array) $data['bcc'];
            foreach ($bcc as $bcc_email) {
                $headers[] = "Bcc: {$bcc_email}";
            }
        }

        return $headers;
    }

    /**
     * Basic spam detection
     * @param $data array
     * @return bool True if spam detected, false otherwise
     */
    public function isSpam(array $data): bool
    {
        // Check for honeypot field
        if (! empty($data['honeypot'])) {
            return true;
        }

        // Check for too many links in message
        $link_count = substr_count(strtolower($data['message'] ?? ''), 'http');
        if ($link_count > 5) {
            return true;
        }

        return false;
    }

    /**
     * Check rate limiting
     *
     * @param  string  $identifier  Email or IP
     * @param  int  $max_count  Maximum number of emails allowed
     * @param  int  $time_period  Time period in seconds
     * @return bool True if within limit, false if exceeded
     */
    public function checkRateLimit($identifier, $max_count = 5, $time_period = 3600, $bypass = false): bool
    {
        if ($bypass) {
            return true;
        }
        $transient_key = 'email_limit_' . md5($identifier);
        $count = get_transient($transient_key);

        if ($count === false) {
            set_transient($transient_key, 1, $time_period);

            return true;
        }

        if ($count >= $max_count) {
            return false;
        }

        set_transient($transient_key, $count + 1, $time_period);

        return true;
    }

    /**
     * Render an email template
     *
     * @param  string  $template  Template name
     * @param  array  $data  Template data
     */
    public function renderTemplate($template, array $data = []): string|false
    {
        $template_path = get_template_directory() . '/views/emails/' . $template . '.php';

        if (! file_exists($template_path)) {
            return false;
        }

        ob_start();
        extract($data);
        include $template_path;

        return ob_get_clean();
    }
}

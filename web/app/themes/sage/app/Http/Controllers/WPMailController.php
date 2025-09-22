<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use WP_Error;
use WP_REST_Request;

class WPMailController
{
    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * Constructor
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Send an email using WordPress mail function
     *
     * @return \WP_REST_Response|\WP_Error
     */
    public function send(WP_REST_Request $request)
    {
        // Prepare email data from request
        $data = [
            'to' => $request->get_param('to'),
            'subject' => $request->get_param('subject'),
            'message' => $request->get_param('message'),
            'from_name' => $request->get_param('from_name'),
            'from_email' => $request->get_param('from_email'),
            'reply_to' => $request->get_param('reply_to'),
            'cc' => $request->get_param('cc'),
            'bcc' => $request->get_param('bcc'),
            'attachments' => $request->get_file_params(),
            'honeypot' => $request->get_param('honeypot'),
        ];

        // Check if this is a test submission
        $isTestMode = filter_var($request->get_param('test_mode'), FILTER_VALIDATE_BOOLEAN);
        $this->mailService->setTestMode($isTestMode);
        
        // Add test mode info to response if enabled
        $responseData = [];
        if ($isTestMode) {
            $responseData['test_mode'] = true;
        }

        // Check for spam
        if ($this->mailService->isSpam($data)) {
            return new WP_Error(
                'spam_detected',
                __('This message was flagged as potential spam.', 'sage'),
                ['status' => 403],
            );
        }

        // Check rate limit (using IP address as identifier)
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        if (! $this->mailService->checkRateLimit($ip, null, null, true)) {
            return new WP_Error(
                'rate_limit_exceeded',
                __('You have exceeded the email sending limit. Please try again later.', 'sage'),
                ['status' => 429],
            );
        }

        // Send the email
        $result = $this->mailService->send($data);

        if (is_wp_error($result)) {
            return $result;
        }

        // Prepare success response
        $response = [
            'success' => true,
            'message' => __('Email sent successfully!', 'sage'),
        ];
        
        // Add test data if in test mode
        if ($isTestMode) {
            $response['test_mode'] = true;
            $response['test_email'] = $this->mailService->getLastTestEmail();
        }

        return rest_ensure_response($response);
    }
}

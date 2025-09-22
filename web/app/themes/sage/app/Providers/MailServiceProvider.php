<?php

namespace App\Providers;

use App\Http\Controllers\WPMailController;
use App\Services\MailService;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MailService::class, function () {
            return new MailService();
        });

        $this->app->singleton(WPMailController::class, function () {
            return new WPMailController(app(MailService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register REST API routes
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    /**
     * Register REST API routes for mail functionality
     */
    public function registerRoutes(): void
    {
        register_rest_route('sage/v1', '/mail', [
            'methods' => 'POST',
            'callback' => function ($request) {
                return $this->app->make(WPMailController::class)->send($request);
            },
            'permission_callback' => function () {
                // Capture $_REQUEST and write to disk
                return check_ajax_referer('wp_rest', '_wpnonce', false);
            },
            'args' => [
                'to' => [
                    'required' => true,
                    'sanitize_callback' => 'sanitize_email',
                ],
                'subject' => [
                    'required' => true,
                    'sanitize_callback' => 'sanitize_text_field',
                ],
                'message' => [
                    'required' => true,
                ],
                // Add other parameters as needed
            ],
        ]);
    }
}

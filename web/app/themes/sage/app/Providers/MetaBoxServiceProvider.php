<?php

namespace App\Providers;

use App\Factories\MetaBoxFactory;
use App\MetaBoxTemplates\MetaBoxTemplateServiceDetails;
use App\MetaBoxTemplates\MetaBoxTemplateSectionDisplay;
use App\MetaBoxTemplates\MetaBoxTemplateServicesPage;
use App\MetaBoxTemplates\MetaBoxTemplatePortfolioProject;
// Import the new template if you haven't already
use App\MetaBoxTemplates\MetaBoxTemplateFeaturedProject;
use App\MetaBoxTemplates\MetaBoxTemplateLocationService;
use Illuminate\Support\ServiceProvider;

class MetaBoxServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register Meta Box templates
        $this->app->singleton(MetaBoxFactory::class, function () {
            $factory = new MetaBoxFactory(); 

            $factory->addTemplate(new MetaBoxTemplateServiceDetails)
                    ->addTemplate(new MetaBoxTemplateSectionDisplay)
                    ->addTemplate(new MetaBoxTemplateServicesPage)
                    ->addTemplate(new MetaBoxTemplatePortfolioProject)
                    ->addTemplate(new MetaBoxTemplateFeaturedProject) // Add the new one
                    ->addTemplate(new MetaBoxTemplateLocationService);

            return $factory;
        });

        // Register Meta Box fields using the factory
        add_filter('rwmb_meta_boxes', function($meta_boxes) {
            // Use app() helper to resolve the factory singleton instance
            return app(MetaBoxFactory::class)->register($meta_boxes);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
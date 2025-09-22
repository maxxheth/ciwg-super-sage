<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;

use \App\PostTypes\PortfolioProject;
use \App\PostTypes\Service;
use \App\PostTypes\ServiceFaq; // Register Service FAQ post type
use \App\PostTypes\ServiceProcess; // Register Service Process post type
use \App\PostTypes\FeaturedProject; // Register Featured Project post type
use App\PostTypes\Location;
use App\PostTypes\LocationService;
use \App\PostTypes\PostTypeFactory;
use App\View\Composers\Portfolio;
use App\View\Composers\LocationService as LocationServiceComposer;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        $this->app->singleton(PostTypeFactory::class, function () {
            return new PostTypeFactory([
                new PortfolioProject(),
                new Service(),
                new ServiceFaq(), // Register Service FAQ post type
                new ServiceProcess(), // Register Service Process post type
                new FeaturedProject(), // Register Featured Project post type
                new Location(),
                new LocationService(),
            ]);
        });
        
        // Register view composers
        $this->app->singleton(Portfolio::class, function () {
            return new Portfolio();
        });
        $this->app->singleton(LocationServiceComposer::class, function () {
            return new LocationServiceComposer();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
    }
}

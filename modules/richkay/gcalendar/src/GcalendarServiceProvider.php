<?php

namespace Richkay\Gcalendar;

use Illuminate\Support\ServiceProvider;

class GcalendarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->loadViewsFrom(__DIR__.'/Views','gc');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/richkay/gcalendar'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
        include __DIR__.'/routes.php';

        $this->mergeConfigFrom(
            __DIR__ . '/Config/gconfig.php', 'gcalendar'
        );

        $this->app->make('Richkay\Gcalendar\Controllers\HolidaysController');

    }
}

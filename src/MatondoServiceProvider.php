<?php

namespace Matondo;

use Illuminate\Support\ServiceProvider;
use Matondo\Mail\MatondoMail;

class MatondoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'matondo');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/matondo'),
        ], 'matondo-views');

        $this->publishes([
            __DIR__.'/./Mail/FaturaMail.php' => app_path('Mail/FaturaMail.php'),
        ], 'matondo-mail');
    }

    public function register()
    {
        $this->app->bind('FaturaMail', function ($app) {
            return new FaturaMail();
        });
    }
}

<?php

namespace Matondo;

use Illuminate\Support\ServiceProvider;

class MatondoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'matondo');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/matondo'),
        ], 'matondo-views');
    }
}

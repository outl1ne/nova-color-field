<?php

namespace OptimistDigital\NovaColorField;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class ColorFieldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('color', __DIR__ . '/../dist/js/field.js');
        });
    }

    public function register()
    {
        //
    }
}

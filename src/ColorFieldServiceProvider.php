<?php

namespace Outl1ne\NovaColorField;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class ColorFieldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('color', __DIR__ . '/../dist/js/field.js');
            Nova::style('color', __DIR__ . '/../dist/css/field.css');
        });
    }

    public function register()
    {
        //
    }
}

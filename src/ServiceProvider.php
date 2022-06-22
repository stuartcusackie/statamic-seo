<?php

namespace stuartcusackie\StatamicSEO;

use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{   

    public function bootAddon()
    {
        $this->registerPublishables();
    }
    
    protected function registerPublishables(): self
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/statamic-seo'),
        ], 'statamic-seo-views');

        return $this;
    }
}
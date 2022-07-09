<?php

namespace stuartcusackie\StatamicSEO;

use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;
use Illuminate\Support\Facades\Event;

class ServiceProvider extends AddonServiceProvider
{   

    public function bootAddon()
    {
        $this->bootAddonPublishables()
             ->bootAddonSubscriber();
    }
    
    protected function bootAddonPublishables(): self
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/statamic-seo'),
        ], 'statamic-seo-views');

        return $this;
    }

    protected function bootAddonSubscriber()
    {
        Event::subscribe(Subscriber::class);

        return $this;
    }
}
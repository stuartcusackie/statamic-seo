<?php

namespace stuartcusackie\StatamicSEO;

use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;
use Illuminate\Support\Facades\Event;
use stuartcusackie\StatamicSEO\StatamicSEO;
use Statamic\Facades\Collection;
use Illuminate\Support\Facades\View;

class ServiceProvider extends AddonServiceProvider
{   

    public function bootAddon()
    {
        $this
            ->registerServices()
            ->registerViewComposers()
            ->bootAddonPublishables()
            ->bootAddonSubscriber();
    }

    protected function registerServices()
    {
        $this->app->singleton('SEO', StatamicSEO::class);

        return $this;
    }

    /**
     * Initialise the SEO data on all collection
     * views.
     */
    protected function registerViewComposers()
    {
        $views = [];

        foreach(Collection::all() as $collection) {
            $views[] = $collection->template();
        }

        View::composer($views, function ($view) {
            $viewData = $view->getData();
            \SEO::init($viewData['site'], $viewData['page']);
        });

        return $this;
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
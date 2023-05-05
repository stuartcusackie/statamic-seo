<?php

namespace stuartcusackie\StatamicSEO;

use Statamic\Providers\AddonServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use stuartcusackie\StatamicSEO\Facades\SEO;

class ServiceProvider extends AddonServiceProvider
{   

    public function bootAddon()
    {
        $this
            ->loadViews()
            ->bootAddonPublishables()
            ->setupViewComposer();
    }

    protected function loadViews(): self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'statamic-seo');

        return $this;
    }

    protected function bootAddonPublishables(): self
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/statamic-seo'),
        ], 'statamic-seo-views');

        $this->publishes([
            __DIR__ . '/../resources/fieldsets' => resource_path('fieldsets/vendor/statamic-seo'),
        ], 'statamic-seo-fieldsets');

        return $this;
    }

    protected function setupViewComposer() {

        View::composer('statamic-seo::seo', function ($view) {

            $view->with([
                'metaTitle' => SEO::metaTitle(),
                'metaDescription' => SEO::metaDescription(),
                'locale' => SEO::locale(),
                'ogTitle' => SEO::ogTitle(),
                'ogDescription' => SEO::ogDescription(),
                'ogImage' => SEO::ogImage(),
                'updatedAt' => SEO::updatedAt(),
                'noIndex' => SEO::noIndex()
            ]);
        });

    }
}

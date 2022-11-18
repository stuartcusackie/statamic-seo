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
            ->bootAddonPublishables()
            ->bootAddonSubscriber()
            ->setupViewComposer();
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

    protected function setupViewComposer() {

        View::composer('vendor.statamic-seo.seo', function ($view) {

            $view->with([
                'metaTitle' => SEO::metaTitle(),
                'metaDescription' => SEO::metaDescription(),
                'locale' => SEO::locale(),
                'ogTitle' => SEO::ogTitle(),
                'ogDescription' => SEO::ogDescription(),
                'ogImage' => SEO::ogImage(),
                'updatedAt' => SEO::updatedAt()
            ]);
        });

    }
}

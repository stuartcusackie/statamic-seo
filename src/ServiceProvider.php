<?php

namespace stuartcusackie\StatamicSEO;

use Statamic\Providers\AddonServiceProvider;
use Illuminate\Support\Facades\Event;
use stuartcusackie\StatamicSEO\StatamicSEO;
use Illuminate\Support\Facades\View;

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

        $seo = new StatamicSEO;

        View::composer('vendor.statamic-seo.seo', function ($view) use ($seo) {

            $seo->initCascadeData();

            $view->with([
                'metaTitle' => $seo->metaTitle(),
                'metaDescription' => $seo->metaDescription(),
                'locale' => $seo->locale(),
                'ogTitle' => $seo->ogTitle(),
                'ogDescription' => $seo->ogDescription(),
                'ogImage' => $seo->ogImage(),
                'updatedAt' => $seo->updatedAt()
            ]);
        });

    }
}

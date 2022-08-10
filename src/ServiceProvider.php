<?php

namespace stuartcusackie\StatamicSEO;

use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;
use Illuminate\Support\Facades\Event;
use stuartcusackie\StatamicSEO\StatamicSEO;
use Statamic\Facades\Entry;
use Statamic\Facades\Term;
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
     * Process the view data that has been set up
     * by Statamic. This is a bit convoluted but
     * it's efficient!
     */
    protected function registerViewComposers()
    {
        // Append slash to path if necessary
        $path = substr(request()->path(), 0, 1) == '/' ? request()->path() : '/' . request()->path();
        $template = null;

        if($entry = Entry::findByUri($path)) {
            $template = $entry->template();
        }
        else if($term = Term::findByUri($path)) {
            $template = $term->template();
        }

        if($template) {

            View::composer($template, function ($view) {
                $viewData = $view->getData();
                \SEO::init($viewData['site'], $viewData['page']);
            });

        }
        
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

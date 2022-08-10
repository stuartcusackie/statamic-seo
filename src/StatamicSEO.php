<?php

namespace stuartcusackie\StatamicSEO;

use Illuminate\Support\Facades\Cache;
use Statamic\Facades\Site;

class StatamicSEO {

    public $seoData = [
        'title' => '',
        'meta_title' => '',
        'meta_description' => '',
        'locale' => '',
        'open_graph_title' => '',
        'open_graph_description' => '',
        'open_graph_image' => '',
        'updated_at' => null
    ];

    /**
     * Set the meta data from the template
     * variables.
     * 
     * @return string
     */
    public function init($site, $page) {

        if(isset($site)) {
            $this->seoData['locale'] = $site->locale();
        }

        if($page) {
            $this->seoData['title'] = $page->title;
            $this->seoData['meta_title'] = $page->meta_title;
            $this->seoData['meta_description'] = $page->meta_description;
            $this->seoData['open_graph_title'] = $page->open_graph_title;
            $this->seoData['open_graph_description'] = $page->open_graph_description;
            $this->seoData['open_graph_image'] = $page->open_graph_image;

            if(isset($page->updated_at)) {
                $this->seoData['updated_at'] = $page->updated_at->toIso8601String();
            }
        }
    }

    /**
     * Return the meta title.
     * or fallback.
     * 
     * @return string
     */
    public function metaTitle() {

        if(strlen($this->seoData['meta_title'])) {
            return $this->seoData['meta_title'];
        }
        else if(strlen($this->seoData['title'])) {
            return $this->seoData['title'] . ' ' . config('statamic-seo.title_append');
        }

        return config('statamic-seo.title');
    }

    /**
     * Return the meta description.
     * 
     * @return string
     */
    public function metaDescription() {

        return $this->seoData['meta_description'];

    }

    /**
     * Return the site locale from seo data
     * or query Statamic directly.
     * 
     * @return string
     */
    public function locale() {

        if(empty($this->seoData['locale'])) {
            return Site::current()->locale();
        }
        
        return $this->seoData['locale'];
    }

    /**
     * Return the Open Graph Title
     * or fallback.
     * 
     * @return string
     */
    public function ogTitle() {

        if(strlen($this->seoData['open_graph_title'])) {
            return $this->seoData['open_graph_title'];
        }

        return $this->metaTitle();
    }

    /**
     * Return the Open Graph Description
     * or fallback.
     * 
     * @return string
     */
    public function ogDescription() {

        if(strlen($this->seoData['open_graph_description'])) {
            return $this->seoData['open_graph_description'];
        }

        return $this->metaDescription();
    }

    /**
     * Return a url for the OG Image.
     * Fall back to config placeholder.
     * 
     * @return string
     */
    public function ogImage() {

        return $this->seoData['open_graph_image'] ?? config('statamic-seo.og_image');
        
    }

    /**
     * Return the page updated_at
     * datetime
     * 
     * @return string
     */
    public function updatedAt() {

        return $this->seoData['updated_at'];

    }

}

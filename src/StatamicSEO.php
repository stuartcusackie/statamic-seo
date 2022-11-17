<?php

namespace stuartcusackie\StatamicSEO;

use Illuminate\Support\Facades\Cache;
use Statamic\Facades\Site;
use Facades\Statamic\View\Cascade;
use Illuminate\Support\Facades\View;

class StatamicSEO {

    protected $page;
    protected $site;

    public function initCascadeData() {

        $cascade = Cascade::instance()->toArray();
        $this->page = $cascade['page'] ?? null;
        $this->site = $cascade['site'] ?? null;

    }

    /**
     * Return the meta title.
     * or fallback.
     * 
     * @return string
     */
    public function metaTitle() {

        if($this->page) {
            return strlen($this->page->meta_title) ? $this->page->meta_title : $this->page->title;
        }

        return config('statamic-seo.title');
    }

    /**
     * Return the meta description.
     * 
     * @return string
     */
    public function metaDescription() {

        if($this->page && strlen($this->page->meta_description)) {
            return $page->meta_description;
        }

    }

    /**
     * Return the site locale from seo data
     * or query Statamic directly.
     * 
     * @return string
     */
    public function locale() {

        if($this->site && $this->site->locale()) {
            return $this->site->locale();
        }
        
    }

    /**
     * Return the Open Graph Title
     * or fallback.
     * 
     * @return string
     */
    public function ogTitle() {

        if($this->page && strlen($this->page->open_graph_title)) {
            return $this->page->open_graph_title;
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

        if($this->page && strlen($this->page->open_graph_description)) {
            return $this->page->open_graph_description;
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

        if($this->page && isset($this->page->open_graph_image)) {
            return $this->page->open_graph_image;
        }

        return config('statamic-seo.og_image');
        
    }

    /**
     * Return the page updated_at
     * datetime
     * 
     * @return string
     */
    public function updatedAt() {

        if($this->page && isset($this->page->updated_at)) {
            return $this->page->updated_at;
        }

    }

}

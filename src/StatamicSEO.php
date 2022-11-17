<?php

namespace stuartcusackie\StatamicSEO;

use Statamic\Facades\Site;
use Facades\Statamic\View\Cascade;

class StatamicSEO {

    /**
     * The source data object
     * Could be an entry or custom object.
     */
    protected $data;

    function __construct() {
        $cascade = Cascade::instance()->toArray();
        $this->data = $cascade['page'] ?? null;
    }

    public function output() {
        return View::make('vendor.statamic-seo.seo');
    }

    /**
     * Initialise the class with a data object.
     * Useful when there is no cascade.
     */
    public function init($data) {
            
        if(is_array($data)) {
            $data = (object) $data;
        }
        
        $this->data = $data;
    }

    /**
     * Return the meta title.
     * or fallback.
     * 
     * @return string
     */
    public function metaTitle() {
        
        if(isset($this->data->meta_title) && strlen($this->data->meta_title)) {
            return $this->data->meta_title;
        }
        else if(isset($this->data->title) && strlen($this->data->title) {
            return $this->data->title;
        }

        return config('statamic-seo.title');
    }

    /**
     * Return the meta description.
     * 
     * @return string
     */
    public function metaDescription() {

        if(isset($this->data->meta_description) && strlen($this->data->meta_description)) {
            return $this->data->meta_description;
        }

    }

    /**
     * Return the site locale from seo data
     * or query Statamic directly.
     * 
     * @return string
     */
    public function locale() {
        return Site::current()->locale();
    }

    /**
     * Return the Open Graph Title
     * or fallback.
     * 
     * @return string
     */
    public function ogTitle() {

        if(isset($this->data->open_graph_title) && strlen($this->data->open_graph_title)) {
            return $this->data->open_graph_title;
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

        if(isset($this->data->open_graph_description) && strlen($this->data->open_graph_description)) {
            return $this->data->open_graph_description;
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

        if(isset($this->data->open_graph_image)) {
            return $this->data->open_graph_image;
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

        if(isset($this->data->updated_at)) {
            return $this->data->updated_at;
        }

    }

}

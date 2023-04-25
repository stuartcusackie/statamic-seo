<?php

namespace stuartcusackie\StatamicSEO;

use Statamic\Facades\Site;
use Facades\Statamic\View\Cascade;
use Illuminate\Support\Facades\View;

class StatamicSEO {

    /**
     * The source data object
     * Could be an entry or custom object.
     */
    protected $data;

    /**
     * Create a new StatamicSEO instance.
     *
     * @return void
     */
    function __construct() {
        $cascade = Cascade::instance()->toArray();
        $this->data = $cascade['page'] ?? null;
    }

    /**
     * Output the seo partial
     * 
     * @return void
     */
    public function output() {
        echo view('statamic-seo::seo')->render();
    }

    /**
     * Initialise the class with a data object.
     * Useful when there is no cascade.
     * 
     * @param mixed $data
     * @return void
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

        if(!$this->data) {
            return 'Page Not Found ' . config('statamic-seo.title_append');
        }
        else if(!empty($this->data->meta_title)) {
            return $this->data->meta_title;
        }
        else if(!empty($this->data->title)) {
           return $this->data->title . config('statamic-seo.title_append');
        }

        return config('app.name') . config('statamic-seo.title_append');
    }

    /**
     * Return the meta description.
     * 
     * @return string
     */
    public function metaDescription() {

        if(!empty($this->data->meta_description)) {
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

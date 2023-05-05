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
    protected $globalSeo;

    /**
     * Create a new StatamicSEO instance.
     *
     * @return void
     */
    function __construct() {
        $cascade = Cascade::instance()->toArray();
        $this->data = $cascade['page'] ?? null;
        $this->globalSeo = $cascade['global_seo'] ?? null; 
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

        $start = '';
        $end = '';
        $separator = $this->globalSeo->title_separator ?? '|';

        // Use the custom title for the entry
        if(!empty($this->data->meta_title)) {
            return $this->data->meta_title;
        }

        // Fallback: start
        if(!$this->data) {
            $start = 'Page Not Found';
        }
        else if(!empty($this->data->title)) {
            $start = $this->data->title;
        }
        
        // Fallback: end
        if(!empty($this->globalSeo->site_name)) {
            $end = $this->globalSeo->site_name;
        }
        else {
            $end = config('app.name');
        }

        return trim($start) . ' ' . $separator . ' ' . trim($end);
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

        if(!empty($this->globalSeo->open_graph_image)) {
            return $this->globalSeo->open_graph_image;
        }
        
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

    /**
     * Return the global noindex setting
     * 
     * @return boolean
     */
    public function noIndex() {

         return (env('APP_ENV') == 'local' && $this->globalSeo->noindex_local) || 
                (env('APP_ENV') == 'staging' && $this->globalSeo->noindex_staging) || 
                (env('APP_ENV') == 'production' && $this->globalSeo->noindex_production);

    }
}

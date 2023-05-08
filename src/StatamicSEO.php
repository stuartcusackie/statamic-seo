<?php

namespace stuartcusackie\StatamicSEO;

use Statamic\Facades\Site;
use Statamic;
use Facades\Statamic\View\Cascade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class StatamicSEO {

    /**
     * The source data object
     * Could be an entry or custom object.
     */
    protected $cascade;
    protected $page;
    protected $globalSeo;
    protected $data;

    /**
     * Create a new StatamicSEO instance
     * and generate the SEO data.
     *
     * @return void
     */
    function __construct() {

        $this->cascade = Cascade::instance()->toArray();
        $this->page = $this->cascade['page'] ?? null;
        $this->globalSeo = $this->cascade['global_seo'] ?? null;

        if(!empty($this->cascade)) {
            $this->generate();
        }
        
    }

    /**
     * Generate the SEO data
     * 
     * @return void
     */
    public function generate() {

        // Fallbacks
        $title = $this->metaTitle();
        $description = $this->metaDescription();

        $this->data = [
            'siteName' => $this->siteName(),
            'metaTitle' => $title,
            'metaDescription' => $description,
            'locale' => $this->locale(),
            'ogTitle' => $this->ogTitle($title),
            'ogDescription' => $this->ogDescription($description),
            'ogImage' => $this->ogImage(),
            'date' => $this->date(),
            'updatedAt' => $this->updatedAt(),
            'noIndex' => $this->noIndex()
        ];

    }

    /**
     * Return the SEO data array
     * 
     * @return array
     */
    public function data() {
        return $this->data;
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
     * Initialise the class with a page object.
     * Useful when there is no cascade.
     * 
     * @param mixed $page
     * @return void
     */
    public function init($page) {
            
        if(is_array($page)) {
            $page = (object) $page;
        }
        
        $this->page = $page;
        $this->generate();
    }

    public function siteName() {

        if(!empty($this->globalSeo->site_name)) {
            return $this->globalSeo->site_name;
        }
        else {
            $end = config('app.name');
        }

    }

    /**
     * Return the meta title.
     * or fallback.
     * 
     * @return string
     */
    public function metaTitle() {

        // Use the custom title for the entry
        if(!empty($this->page->meta_title)) {
            return $this->page->meta_title;
        }

        // Fallback
        $start = '';
        $separator = $this->globalSeo->title_separator ?? '|';

        if(!$this->page) {
            $start = 'Page Not Found';
        }
        else if(!empty($this->page->title)) {
            $start = $this->page->title;
        }
        
        return trim($start) . ' ' . $separator . ' ' . trim($this->siteName());
    }


    /**
     * Return the meta description.
     * 
     * @return string
     */
    public function metaDescription() {

        if(!$this->page) {
            return '';
        }

        if(!empty($this->page->meta_description)) {
            return $this->page->meta_description;
        }

        // Fallback to global description settings
        foreach($this->globalSeo->collection_defaults as $settings) {

            if($settings->collection->handle == $this->page->collection->handle) {

                if($settings->fallback == 'custom_text') {
                    return $settings->custom_text;
                }
                else if($settings->fallback == 'field' && 
                        array_key_exists($settings->field_handle, $this->cascade)) {
                    return Str::limit($this->getFieldText($this->cascade[$settings->field_handle]), 152);
                }

                break;
            }

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
     * @param string $fallback
     * @return string
     */
    public function ogTitle($fallback) {

        if(isset($this->page->open_graph_title) && strlen($this->page->open_graph_title)) {
            return $this->page->open_graph_title;
        }

        return $fallback;
    }

    /**
     * Return the Open Graph Description
     * or fallback.
     * 
     * @param string $fallback
     * @return string
     */
    public function ogDescription($fallback) {

        if(isset($this->page->open_graph_description) && strlen($this->page->open_graph_description)) {
            return $this->page->open_graph_description;
        }

        return $fallback;
    }

    /**
     * Return a url for the OG Image.
     * Fall back to config placeholder.
     * 
     * @return string
     */
    public function ogImage() {

        if(isset($this->page->open_graph_image)) {
            return $this->page->open_graph_image;
        }

        if(!empty($this->globalSeo->open_graph_image)) {
            return $this->globalSeo->open_graph_image;
        }
        
    }

    /**
     * Return the page date
     * datetime
     * 
     * @return string
     */
    public function date() {

        if(isset($this->page->date)) {
            return $this->page->date;
        }

    }

    /**
     * Return the page updated_at
     * datetime
     * 
     * @return string
     */
    public function updatedAt() {

        if(isset($this->page->updated_at)) {
            return $this->page->updated_at;
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

    /**
     * Merge the text from all the set in a
     * replicator field
     * 
     * @param Statamic\Fields\Value $replicator
     * @return string
     */
    public function getReplicatorText($replicator) {

        $segments = [];

        foreach($replicator as $set) {
            foreach($set as $key => $field) {
                if(is_object($field) && get_class($field) == 'Statamic\Fields\Value') {

                    $text = $this->getFieldText($field);

                    if(!empty($text)) {
                        $segments[] = $text;
                    }

                }                                        
            }
        }

        return $this->simplifyText(implode('. ', $segments));

    }

    /**
     * Return the text from various types 
     * of Statamic fields.
     * 
     * @param Statamic\Fields\Value $field
     * @return string
     */
    public function getFieldText(Statamic\Fields\Value $field) {  

        $class = get_class($field->fieldtype());

        if($class == 'Statamic\Fieldtypes\Replicator') {
            return $this->getReplicatorText($field);
        }
        else if($class == 'Statamic\Fieldtypes\Bard') {
            return Statamic::modify($field)->bard_text();
        }
        else if($class == 'Statamic\Fieldtypes\Textarea' ||
            $class == 'Statamic\Fieldtypes\Markdown') {
            return $field->raw();
        }

    }

    /**
     * Return nice text without all the formatting.
     * Suitable for a meta description.
     * 
     * @param string $text
     * @return string
     */
    public function simplifyText($text) {

        $text = preg_replace("/[^a-zA-Z0-9.,;!? ]+/", " ", $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = htmlentities($text);
        
        return trim($text);

    }
}

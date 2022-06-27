<?php

use Illuminate\Support\Str;

/**
 * META HELPERS
 */

if(!function_exists('seo_data')) {

    /**
     * Generate an special array of SEO data 
     * for our custom implementation.
     * 
     * @param Entry $page
     * @return array
     */
    function seo_data($page = null) {

        $data = [
            'title' => '',
            'meta_title' => '',
            'meta_description' => '',
            'open_graph_title' => '',
            'open_graph_description' => '',
            'open_graph_image' => ''
        ];

        if($page) {
            $data['title'] = $page->title;
            $data['meta_title'] = $page->meta_title;
            $data['meta_description'] = $page->meta_description;
            $data['open_graph_title'] = $page->open_graph_title;
            $data['open_graph_description'] = $page->open_graph_description;
            $data['open_graph_image'] = $page->open_graph_image;
        }

        return $data;
    }
}

if(!function_exists('get_meta_title')) {

	/**
     * Generate the meta title.
     * 
     * @param Array $seoData
     * @return string
     */
    function get_meta_title(array $seoData) {

        if(strlen($seoData['meta_title'])) {
            return $seoData['meta_title'];
        }
        else if(strlen($seoData['title'])) {
            return $seoData['title'] . ' ' . config('statamic-seo.title_append');
        }

    	return config('statamic-seo.title');
    }
}

if(!function_exists('get_meta_description')) {

	/**
     * Generate the meta description for a Statamic page
     * Passing page by reference to suppress 
     * undefined variable warnings.
     * 
     * @param Array $seoData
     * @return string
     */
    function get_meta_description(array $seoData) {

        return $seoData['meta_description'];

    }
}

if(!function_exists('get_og_title')) {

	/**
     * Generate the Open Graph title for a Statamic page.
     * Passing page by reference to suppress 
     * undefined variable warnings.
     * 
     * @param Array $seoData
     * @return string
     */
    function get_og_title(array $seoData) {

        if(strlen($seoData['open_graph_title'])) {
            return $seoData['open_graph_title'];
        }

        return get_meta_title($seoData);
    }
}

if(!function_exists('get_og_description')) {

	/**
     * Generate the Open Graph description for a page.
     * Passing page by reference to suppress 
     * undefined variable warnings.
     * 
     * @param Array $seoData
     * @return string
     */
    function get_og_description(array $seoData) {

        if(strlen($seoData['open_graph_description'])) {
            return $seoData['open_graph_description'];
        }

    	return get_meta_description($seoData);
    }
}

if(!function_exists('get_og_image')) {

    /**
     * Return a url for the OG Image.
     * Falls back to placeholder.
     * 
     * @param Array $seoData
     * @return string
     */
    function get_og_image(array $seoData) {

        return $seoData['open_graph_image'] ?? config('statamic-seo.og_image');
        
    }
}

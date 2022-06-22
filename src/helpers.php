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
    function seo_data($page) {

        $data = [
            'title' => $page->title
        ];

        if(strlen($page->metaTitle)) {
            $data['meta_title'] = $page->metaTitle;
        }

        if(strlen($page->metaDescription)) {
            $data['meta_description'] = $page->metaDescription;
        }

        if(strlen($page->openGraphTitle)) {
            $data['open_graph_title'] = $page->openGraphTitle;
        }

        if(strlen($page->openGraphDescription)) {
            $data['open_graph_description'] = $page->openGraphDescription;
        }

        if($page->openGraphImage && $page->openGraphImage->raw()) {
            $data['open_graph_image'] = $page->openGraphImage;
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

        if(isset($seoData['meta_title'])) {
            return $seoData['meta_title'];
        }

    	return $seoData['title'] . config('seo.title_append');
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

        return $seoData['meta_description'] ?? '';

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

        if(isset($seoData['open_graph_title'])) {
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

        if(isset($seoData['open_graph_description'])) {
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

        /** 
         * We have to fix the url because of this bug:
         * https://github.com/statamic/cms/issues/5593 
         * crop_focal will not work here probably.
         */

        if(isset($seoData['open_graph_image'])) {
            return Statamic::modify($seoData['open_graph_image'])->fixAssetUrl()->fetch();
        }

        return config('seo.og_image') ?? null;
        
    }
}
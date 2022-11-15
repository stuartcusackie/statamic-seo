<?php

namespace stuartcusackie\StatamicSEO;

use Statamic\Events;
use Statamic\Facades\Collection;
use Statamic\Facades\Taxonomy;
use Statamic\Support\Str;

class Subscriber
{
    /**
     * Subscribed events.
     *
     * @var array
     */
    protected $events = [
        Events\EntryBlueprintFound::class => 'ensureSeoFields',
        Events\TermBlueprintFound::class => 'ensureSeoFields'
    ];

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        foreach ($this->events as $event => $method) {
            $events->listen($event, self::class.'@'.$method);
        }
    }

    /**
     * Ensure seo fields are added as a section
     * on the appropriate blueprints.
     *
     * @param mixed $event
     */
    public function ensureSeoFields($event)
    {
        if (in_array($event->blueprint->handle(), config('statamic-seo.excluded_blueprints', [])))
            return;

        foreach($this->getFields() as $field) {
            $event->blueprint->ensureFieldInSection($field['handle'], $field['field'] , 'SEO');
        };
    }

    /**
     * Return the fields for the SEO section.
     *
     * @return array
     */
    private function getFields()
    {
        return [[
            'handle' => 'meta_title',
            'field' => [
                'input_type' => 'text',
                'character_limit' => 60,
                'antlers' => false,
                'display' => 'Title',
                'type' => 'text',
                'icon' => 'text',
                'listable' => 'hidden'
            ]], [
            'handle' =>  'meta_description',
            'field' => [
                'antlers' => false,
                'display' => 'Description',
                'type' => 'textarea',
                'icon' => 'textarea',
                'listable' => 'hidden',
                'character_limit' => 160,
            ]], [
            'handle' => 'open_graph_title',
            'field' => [
                'input_type' => 'text',
                'character_limit' => 100,
                'antlers' => false,
                'display' => 'Open Graph Title',
                'type' => 'text',
                'icon' => 'text',
                'instructions' => 'OG data is used by various social media sites',
                'listable' => 'hidden'
            ]], [
            'handle' => 'open_graph_description',
            'field' => [
                'character_limit' => 300,
                'antlers' => false,
                'display' => 'Open Graph Description',
                'type' => 'textarea',
                'icon' => 'textarea',
                'listable' => 'hidden'
            ]], [
            'handle' => 'open_graph_image',
            'field' => [
                'mode' => 'grid',
                'container' => 'images',
                'restrict' => false,
                'allow_uploads' => true,
                'max_files' => 1,
                'display' => 'Open Graph Image',
                'type' => 'assets',
                'icon' => 'assets',
                'listable' => 'hidden',
                'instructions' => 'This image will be automatically cropped to 1200 x 627 pixels.'
            ]]
        ];
    }
}

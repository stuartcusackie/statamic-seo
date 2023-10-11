# STATAMIC SEO

A simple Blade SEO package for Statamic 3. WARNING: Use with caution. Not tested very well. I use this package for unusual Statamic projects of my own.

## Installation

First, install the package.

```
composer require stuartcusackie/statamic-seo
```

Then, set up a global fieldset with handle 'global_seo'. Assign the statamic-seo:global_seo fieldset to this.


## Publish

You should publish both views and fieldsets. You may need to configure the asset containers for image fields in each fieldset, defaults to 'assets'.

```
php please vendor:publish --tag=statamic-seo-views
php please vendor:publish --tag=statamic-seo-fieldsets
```

## Usage

Simply call the facade in your template's head.

```
{{ SEO::output() }}
```

## IMPORTANT: Custom Routes

When using custom routes you will need to initiate your entry using the facade.

```
use stuartcusackie\StatamicSEO\Facades\SEO;

public function customRoute(Request $request, $entry) {

  $view = (new \Statamic\View\View)
    ->template($entry->template)
    ->layout('layouts/custom')
    ->with(['page' => $entry]);

  SEO::initCascadeArray($view->gatherData());

  return $view;
}
```

## TODO
- Try to convert global 'collection' fallbacks to global 'blueprint' fallbacks.
  - Collections may not always contain the fallback field.
  - This should work for terms as well.
- Set up blueprint / collection based fallbacks for og image.
- Add schemas
  - Breadcrumbs with toggling option
  - Per page schemas

# STATAMIC SEO

A simple SEO package for Statamic 3

## Installation

```
composer require stuartcusackie/statamic-seo
```

## Publish

```
php please vendor:publish --tag=statamic-seo-config
php please vendor:publish --tag=statamic-seo-views
```

## Config

See config file.

## Usage

@include('vendor.statamic-seo.seo')

## IMPORTANT: Custom Routes

Custom routes that are set up in web.php and that use custom controllers won't be initialised with the Statamic SEO data.

If you are returning a view in your custom controllers then you can initialise the SEO data like so:

```
View::composer('pages/custom-view', function ($view) {
  $viewData = $view->getData();
  \SEO::init($viewData['site'], $viewData['page']);
});
```

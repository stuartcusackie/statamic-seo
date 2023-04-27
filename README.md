# STATAMIC SEO

A simple Blade SEO package for Statamic 3.

## Installation

```
composer require stuartcusackie/statamic-seo
```

## Publish

```
php please vendor:publish --tag=statamic-seo-config
php please vendor:publish --tag=statamic-seo-fieldsets
php please vendor:publish --tag=statamic-seo-views
```

## Config

See config file.

## Usage

Simply call the facade in your template's head.

```
{{ SEO::output() }}
```

## IMPORTANT: Custom Routes

When using custom routes you will need to initiate your entry using the facade.

```
use stuartcusackie\StatamicSEO\Facades\SEO;

SEO::init($page);
```

## TODO:

- Check if Subscriber is affecting performance: Replace with artisan commands if so.

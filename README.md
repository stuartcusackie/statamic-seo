# STATAMIC SEO

A simple Blade SEO package for Statamic 3.

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

SEO::init($page);
```

## TODO
- Set up global collection description fallbacks

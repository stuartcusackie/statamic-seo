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

Simple call this in your template's head.

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

- 404 error pages are causing exceptions. For the moment the best strategy is to use a condition in your layout:

Template inheritance example
```
@hasSection('metaOveride')
  @yield('metaOveride)
@else
  {{ SEO::output() }}
@endif
```

Component example
```
@if(isset($metaOverride)) {{ $metaOverride }} @else {{ SEO::output() }} @endif
```

I will improve this in future by handling http exceptions within the package.

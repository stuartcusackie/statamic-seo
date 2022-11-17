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

When using custom routes you will need to initiate the Facade with your page entry and Statamic site variables.

```
\SEO::setPage($page);
\SEO::setSite($site);
```

<?php

namespace stuartcusackie\StatamicSEO\Facades;

use Illuminate\Support\Facades\Facade;
use stuartcusackie\StatamicSEO\StatamicSEO;

class SEO extends Facade
{
    protected static function getFacadeAccessor()
    {
        return StatamicSEO::class;
    }
}
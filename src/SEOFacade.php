<?php

namespace stuartcusackie\StatamicSEO;

use Illuminate\Support\Facades\Facade;

class SEOFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SEO';
    }
}
<?php

namespace NovaAdDirector\Facades;

use Illuminate\Support\Facades\Facade;

class NovaAdDirector extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NovaAdDirector\NovaAdDirector::class;
    }
}

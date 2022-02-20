<?php

namespace Pns\LaravelQbo\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelQbo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-qbo';
    }
}
?>
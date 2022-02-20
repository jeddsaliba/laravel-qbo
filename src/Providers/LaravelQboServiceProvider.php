<?php

namespace Pns\LaravelQbo\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelQboServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Config/qbo.php' => config_path('qbo.php'),
        ]);
    }
    public function register()
    {

    }
}
?>
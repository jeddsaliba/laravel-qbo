<?php

namespace Pns\LaravelQbo\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelQboServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('qbo.php'),
            ], 'config');
        }
    }
    public function register()
    {

    }
}
?>
<?php

namespace Pns\LaravelQbo\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelQboServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            /* publish config */
            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('qbo.php'),
            ], 'config');
            if (!class_exists('CreateQboConfigTable')) {
                $this->publishes([
                  __DIR__ . '/../database/migrations/create_qbo_config_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_qbo_config_table.php'),
                  // you can add any number of migrations here
                ], 'migrations');
            }
        }
        $this->registerRoutes();
    }
    public function register()
    {

    }
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }
    protected function routeConfiguration()
    {
        return [
            'prefix' => config('qbo.prefix'),
            'middleware' => config('qbo.middleware'),
        ];
    }
}
?>
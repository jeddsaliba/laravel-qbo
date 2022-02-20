<?php

namespace Pns\LaravelQbo\Providers;

use Illuminate\Support\ServiceProvider;

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
                  __DIR__ . '/../database/migrations/create_qbo_config_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_qbo_config_table.php'),
                  // you can add any number of migrations here
                ], 'migrations');
            }
        }
    }
    public function register()
    {

    }
}
?>
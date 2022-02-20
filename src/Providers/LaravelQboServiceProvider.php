<?php

namespace Pns\LaravelQbo\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelQboServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerConfig();
            $this->registerMigrations();
        }
        $this->registerRoutes();
    }
    public function register()
    {

    }
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('qbo.php'),
        ], 'config');
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
    protected function registerMigrations()
    {
        if (!class_exists('CreateQboConfigTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_qbo_config_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_qbo_config_table.php'),
            ], 'migrations');
        }
        if (!class_exists('CreateQboInvoiceTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_qbo_invoices_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_qbo_invoices_table.php')
            ], 'migrations');
        }
    }
}
?>
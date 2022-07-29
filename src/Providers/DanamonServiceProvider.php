<?php

namespace Ridhwan\LaravelBankDanamon\Providers;

use Ridhwan\LaravelBankDanamon\Danamon;
use Illuminate\Support\ServiceProvider;

class DanamonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../../config/bank-danamon.php' => config_path('bank-danamon.php'),
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/bank-danamon.php', 'bank-danamon');

        $this->app->singleton('DanamonAPI', function () {
            return new Danamon();
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    //     if ($this->app->isLocal()) {
    //         //if local register your services you require for development
    //       $this->app->register('Barryvdh\Debugbar\ServiceProvider');
    //   }else{
    //         //else register your services you require for production
    //       $this->app['request']->server->set('HTTPS', true);
    //   }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if(env("APP_ENV") !== "local"){
        //     URL::forceScheme('https');
        // }
        // URL::forceScheme('https');
    //     if (!$this->app->isLocal()) {
    //         $this->app['request']->server->set('HTTPS', true);
    //    }

        //URL::forceScheme('https');
        Schema::defaultStringLength(191);
    }
}

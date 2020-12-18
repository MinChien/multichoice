<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//         if (!$this->app->isLocal()) {
//         $this->app['request']->server->set('HTTPS', true);
//         } 
        if(env('APP_ENV') !== 'local'){
            URL::forceScheme('https');
        }  
    }
}

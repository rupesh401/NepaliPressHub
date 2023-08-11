<?php

namespace App\Providers;

use View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
       //Share to All View
       View::share([
        'appTitle' => 'Tech Viewed',
        'company' => 'FJMlabs',
        'pF' => pF(),
    ]);
    }
}

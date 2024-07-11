<?php

namespace App\Providers;

use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
        app()->useLangPath(base_path('lang'));
        User::observe(UserObserver::class);
        //Paginator::useBootstrap();

        Validator::extend('rif', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[JVEGP]\d{1,10}$/', $value);
        });

        Validator::extend('telefono', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?:0(212|412|416|426|414|424|264|264|286|292|293|295)|4(12|16|26)|2(12|16|26))\d{7}$/', $value);
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Channel;
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
        Schema::defaultStringLength(191);

        //view()->share();
       
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $channels = \Cache::remember('channels', 15000, function() {
            return Channel::all();
        });

        \View::share('channels', $channels);

        \Validator::extend('spamfree', 'App\Rules\Spamfree@passes');
    }
}

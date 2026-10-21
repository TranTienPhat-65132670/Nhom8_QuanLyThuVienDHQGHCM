<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $user = null;
            if (session()->has('user_id')) {
                $user = DB::table('user')->where('user_id', session('user_id'))->first();
            }
            $view->with('currentUser', $user);
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

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
        // register route middleware alias for is_admin
        if(method_exists(Route::class, 'aliasMiddleware')){
            Route::aliasMiddleware('is_admin', IsAdmin::class);
        }
    }
}

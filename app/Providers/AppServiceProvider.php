<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

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
        //Hacer que el recordarme dure 14 días
        Auth::guard('web')->setRememberDuration(14 * 24 * 60);
        //Para el paginador
        Paginator::useBootstrapFive();
    }
}

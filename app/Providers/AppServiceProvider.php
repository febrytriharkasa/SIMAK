<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        // Pilih sesuai versi Bootstrap
        Paginator::useBootstrapFive(); // kalau pakai Bootstrap 5
        // Paginator::useBootstrapFour(); // kalau pakai Bootstrap 4
    }
}

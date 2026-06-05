<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Dedoc\Scramble\Scramble;

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
        Gate::define('viewApiDocs', function ($user = null) {
            // Izinkan akses berdasarkan kondisi tertentu
            return app()->environment('local') 
                || $user?->is_admin;
            // atau bisa pakai IP whitelist, API key, dll
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        Schema::defaultStringLength(191);

        // Paksa HTTPS jika APP_URL menggunakan https
        if (str_contains(config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        try {
            if (Schema::hasTable('settings')) {
                $appSetting = Setting::first();
                View::share('appSetting', $appSetting);
            }
        } catch (\Exception $e) {
            // Do nothing if DB is not ready
        }
    }
}

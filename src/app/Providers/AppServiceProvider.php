<?php

namespace App\Providers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


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
        // xeicon 보안 문제 때문에 추가 
        // fly.io서버에서만 실행
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            Vite::useBuildDirectory('.vite');
        }
    }
}

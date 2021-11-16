<?php

namespace App\Providers;

use App\Contracts\OTPRequestInterface;
use App\Contracts\VINRequestInterface;
use App\Repositories\DbOTPRequestRepository;
use App\Repositories\DbVINRequestRepository;
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
        $this->app->bind(
            OTPRequestInterface::class,
            DbOTPRequestRepository::class
        );
        $this->app->bind(
            VINRequestInterface::class,
            DbVINRequestRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

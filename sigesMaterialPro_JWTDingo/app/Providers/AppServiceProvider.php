<?php

namespace App\Providers;

use App\Services\CarouselService;
use Illuminate\Support\Facades\View;
use App\Services\NavbarMessageService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\NavbarNotificationService;
use App\Http\ViewComposer\DashboardViewComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('layouts.partials.dashboard._companies-select', DashboardViewComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('navbar.messages', NavbarMessageService::class);

        $this->app->singleton('navbar.notifications', NavbarNotificationService::class);

        $this->app->singleton('carousel', CarouselService::class);
    }
}

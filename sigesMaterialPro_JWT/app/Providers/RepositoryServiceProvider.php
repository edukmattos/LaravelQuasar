<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\CompanyRepository::class, \App\Repositories\CompanyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CompanyUserRepository::class, \App\Repositories\CompanyUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TenantConnectionRepository::class, \App\Repositories\TenantConnectionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BusinessTypeRepository::class, \App\Repositories\BusinessTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ClientSectorRepository::class, \App\Repositories\ClientSectorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MaterialUnitRepository::class, \App\Repositories\MaterialUnitRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ClientSubSectorRepository::class, \App\Repositories\ClientSubSectorRepositoryEloquent::class);
        //:end-bindings:
    }
}

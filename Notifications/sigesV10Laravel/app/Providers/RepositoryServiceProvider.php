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
        $this->app->bind(\App\Api\V1\Repositories\CompanyRepository::class, \App\Api\V1\Repositories\CompanyRepositoryEloquent::class);
        $this->app->bind(\App\Api\V1\Repositories\BusinessTypeRepository::class, \App\Api\V1\Repositories\BusinessTypeRepositoryEloquent::class);
        $this->app->bind(\App\Api\V1\Repositories\ClientRepository::class, \App\Api\V1\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\App\Api\V1\Repositories\ClientTypeRepository::class, \App\Api\V1\Repositories\ClientTypeRepositoryEloquent::class);
        $this->app->bind(\App\Api\V1\Repositories\ClientAddressRepository::class, \App\Api\V1\Repositories\ClientAddressRepositoryEloquent::class);
        $this->app->bind(\App\Api\V1\Repositories\ClientStatusRepository::class, \App\Api\V1\Repositories\ClientStatusRepositoryEloquent::class);
        $this->app->bind(\App\Api\V1\Repositories\OrderRepository::class, \App\Api\V1\Repositories\OrderRepositoryEloquent::class);
        $this->app->bind(\App\Api\V1\Repositories\OrderNoteRepository::class, \App\Api\V1\Repositories\OrderNoteRepositoryEloquent::class);
        //:end-bindings:
    }
}

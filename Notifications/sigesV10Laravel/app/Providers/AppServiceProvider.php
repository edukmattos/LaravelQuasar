<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Api\V1\Serializers\NoDataArraySerializer;

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
        app('Dingo\Api\Transformer\Factory')->setAdapter(function () {
            $fractalManager = new \League\Fractal\Manager;
            $fractalManager->setSerializer(new NoDataArraySerializer);
            return new \Dingo\Api\Transformer\Adapter\Fractal($fractalManager);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

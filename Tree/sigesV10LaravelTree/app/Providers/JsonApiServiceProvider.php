<?php

namespace App\Providers;

use League\Fractal\Manager;
use Illuminate\Support\ServiceProvider;
use Dingo\Api\Transformer\Adapter\Fractal;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('League\Fractal\Manager', function($app) {
            $fractal = new Manager();
            $serializer = new JsonApiSerializer();
            $fractal->setSerializer($serializer);
        
            return $fractal;
        });
        
        $this->app->bind('Dingo\Api\Transformer\Adapter\Fractal', function($app) {
            $fractal = $app->make('\League\Fractal\Manager');
        
            return new Fractal($fractal);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

use Dingo\Api\Routing\Router;

#use Illuminate\Http\Request;

#Route::group(['middleware' => 'api'], function() {
#    Route::group(['prefix' => 'auth'], function() {
#        Route::post('/register', 'Api\V1\Auth\RegisterController@register');
#        Route::post('/login', 'Api\V1\Auth\AuthController@login')->name('login');
#        Route::post('/password/email', 'Api\V1\Auth\ForgotPasswordController@sendResetLinkEmail');

#        Route::group(['middleware' => 'auth'], function() {
#            Route::post('/logout', 'Api\V1\Auth\AuthController@logout');
#            Route::post('/refresh', 'Api\V1\Auth\AuthController@refresh');
#            Route::post('/me', 'Api\V1\Auth\AuthController@me');
#        });
#    });

#    Route::get('/businessTypes/autocomplete', 'Api\V1\BusinessTypesController@autocomplete')->name('businessTypes.autocomplete');
#});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    #$api->get('users', 'App\Http\Controllers\Api\UserController@getUsers');
    $api->group(['middleware' => 'cors'], function ($api) {
        $api->group(['middleware' => 'api'], function ($api) {
            $api->group(['prefix' => 'auth'], function ($api) {
                $api->post('/register', 'App\Http\Controllers\Api\V1\Auth\RegisterController@register');
                $api->post('/login', 'App\Http\Controllers\Api\V1\Auth\AuthController@login')->name('login');
                $api->post('/password/email', 'App\Http\Controllers\Api\V1\Auth\ForgotPasswordController@sendResetLinkEmail');
        
                $api->group(['middleware' => 'auth'], function ($api) {
                    $api->post('/logout', 'App\Http\Controllers\Api\V1\Auth\AuthController@logout');
                    $api->post('/refresh', 'App\Http\Controllers\Api\V1\Auth\AuthController@refresh');
                    $api->post('/me', 'App\Http\Controllers\Api\V1\Auth\AuthController@me');
                });
            });

            $api->get('/companies/user/{user_id}', 'App\Http\Controllers\Api\V1\CompanyUsersController@user')->name('companies_user.index');
            $api->get('/companies/create', 'App\Http\Controllers\Api\V1\CompaniesController@create')->name('companies.create');
            $api->post('/companies', 'App\Http\Controllers\Api\V1\CompaniesController@store')->name('companies.store');
            $api->get('/companies/{id}', 'App\Http\Controllers\Api\V1\CompaniesController@show')->name('companies.show');

            $api->get('/companies/user/{user_id}', 'App\Http\Controllers\Api\V1\CompanyUsersController@user')->name('companies_user.index');
            $api->get('/businessTypes/autocomplete', 'App\Http\Controllers\Api\V1\BusinessTypesController@autocomplete')->name('businessTypes.autocomplete');
        });
    });
});




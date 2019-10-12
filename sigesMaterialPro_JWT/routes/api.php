<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'api'], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('/register', 'Api\V1\Auth\RegisterController@register');
        Route::post('/login', 'Api\V1\Auth\AuthController@login')->name('login');
        Route::post('/password/email', 'Api\V1\Auth\ForgotPasswordController@sendResetLinkEmail');

        Route::group(['middleware' => 'auth'], function() {
            Route::post('/logout', 'Api\V1\Auth\AuthController@logout');
            Route::post('/refresh', 'Api\V1\Auth\AuthController@refresh');
            Route::post('/me', 'Api\V1\Auth\AuthController@me');
        });
    });

    Route::get('/businessTypes/autocomplete', 'Api\V1\BusinessTypesController@autocomplete')->name('businessTypes.autocomplete');
});

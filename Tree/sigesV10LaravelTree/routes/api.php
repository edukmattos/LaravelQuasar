<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['middleware' => 'cors'], function(Router $api) {

        $api->get('/companySectors/tree', 'App\\Api\\V1\\Controllers\\CompanySectorsController@tree')->name('companySectors.tree');
        $api->get('/companySectors/{id}/show', 'App\\Api\\V1\\Controllers\\CompanySectorsController@show')->name('companySectors.show');

        $api->group(['prefix' => 'auth'], function(Router $api) {
            $api->post('/signup', 'App\\Api\\V1\\Controllers\\Auth\\SignUpController@signUp');
            $api->post('/login', 'App\\Api\\V1\\Controllers\\Auth\\LoginController@login');
            $api->get('/activation/{email}/{activation_code}', 'App\\Api\\V1\\Controllers\\Auth\\ActivationController@verify');

            $api->post('/recovery', 'App\\Api\\V1\\Controllers\\Auth\\ForgotPasswordController@sendResetEmail');
            $api->post('/reset', 'App\\Api\\V1\\Controllers\\Auth\\ResetPasswordController@resetPassword');

            $api->post('/logout', 'App\\Api\\V1\\Controllers\\Auth\\LogoutController@logout');
            $api->post('/refresh', 'App\\Api\\V1\\Controllers\\Auth\\RefreshController@refresh');
            $api->get('/me', 'App\\Api\\V1\\Controllers\\UserController@me');
        });

        $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
            ######
            $api->post('/companies', 'App\\Api\\V1\\Controllers\\CompaniesController@store')->name('companies.store');
            $api->get('/companies/{id}', 'App\\Api\\V1\\Controllers\\CompaniesController@show')->name('companies.show');
            $api->post('/companies/{id}/update', 'App\\Api\\V1\\Controllers\\CompaniesController@update')->name('companies.update');
            $api->get('/companies/{id}/destroy', 'App\\Api\\V1\\Controllers\\CompaniesController@destroy')->name('companies.destroy');
            $api->get('/businessTypes/autocomplete', 'App\\Api\\V1\\Controllers\\BusinessTypesController@autocomplete')->name('businessTypes.autocomplete');
            $api->get('/businessTypes/{id}', 'App\\Api\\V1\\Controllers\\BusinessTypesController@show')->name('businessTypes.show');
            $api->get('/myCompanies', 'App\\Api\\V1\\Controllers\\UserController@myCompanies')->name('myCompanies');
            ######
        
               $api->get('/protected', function() {
                return response()->json([
                    'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
                ]);
            });

            $api->get('/refresh', [
                'middleware' => 'jwt.refresh',
                function() {
                    return response()->json([
                        'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                    ]);
                }
            ]);
        });

        $api->get('/hello', function() {
            return response()->json([
                'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
            ]);
        });
    });
});

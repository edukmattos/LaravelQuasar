<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login Routes...
#Route::get('/login', ['as' => 'login', 'uses' => 'Api\V1\Auth\LoginController@showLoginForm']);
#Route::post('/login', ['as' => 'login.post', 'uses' => 'Api\V1\Auth\LoginController@login']);
#Route::post('/logout', ['as' => 'logout', 'uses' => 'Api\V1\Auth\LoginController@logout']);
#Route::get('/logout', 'Api\V1\Auth\LoginController@logout');

// Registration Routes...
Route::get('/register', ['as' => 'register', 'uses' => 'Api\V1\Auth\RegisterController@showRegistrationForm']);
Route::post('/register', ['as' => 'register.post', 'uses' => 'Api\V1\Auth\RegisterController@register']);

// Password Reset Routes...
Route::get('/password/request', ['as' => 'password.request', 'uses' => 'Api\V1\Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('/password/email', ['as' => 'password.email', 'uses' => 'Api\V1\Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('/password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Api\V1\Auth\ResetPasswordController@showResetForm']);
Route::post('/password/update', ['as' => 'password.update', 'uses' => 'Api\V1\Auth\ResetPasswordController@reset']);

// Email Verification Routes...
Route::get('/email/verify', 'Api\V1\Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}', 'Api\V1\Auth\VerificationController@verify')->name('verification.verify');
Route::get('/email/resend', 'Api\V1\Auth\VerificationController@resend')->name('verification.resend');

Route::get('/plans', 'Api\V1\PlansController@index')->name('plans.pricing');
Route::get('/plans/show/{plan}', 'Api\V1\PlansController@index')->name('plans.show');

Route::get('/businessTypes/autocomplete', 'Api\V1\BusinessTypesController@autocomplete')->name('businessTypes.autocomplete');

#Route::group(['middleware' => 'verified'], function() {
    Route::get('/companies/user', 'Api\V1\CompanyUsersController@user')->name('companies_user.index');
    Route::get('/companies/create', 'Api\V1\CompaniesController@create')->name('companies.create');
    Route::post('/companies', 'Api\V1\CompaniesController@store')->name('companies.store');

    Route::get('/tenant/{company}', 'Api\V1\TenantController@switch')->name('tenant.switch');
    
#});

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home-two', 'HomeController@homeTwo')->name('home-two');


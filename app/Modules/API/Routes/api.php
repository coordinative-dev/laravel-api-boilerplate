<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api'])->group(function () {
    Route::group([
        'prefix' => 'auth',
    ], function ($router) {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('refresh-token', 'AuthController@refresh');
        Route::post('request-password-reset', 'ForgotPasswordController@sendResetLinkEmail');
    });

    Route::get('/users/{user}', 'UserController@show')->middleware('auth:api');

    Route::group([
        'prefix' => 'user-profile',
        'middleware' => ['auth:api'],
    ], function ($router) {
        Route::get('/', 'UserProfileController@me');
        Route::patch('/', 'UserProfileController@update');
        Route::patch('change-password', 'UserProfileController@changePassword');
        Route::post('change-avatar', 'UserProfileController@changeAvatar');
    });
});

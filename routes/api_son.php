<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api\V1','prefix' => 'v1','as'=>'api.'],function(){
    Route::post('/login','Auth\LoginController@login');
    Route::post('/refresh-token-remember','Auth\LoginController@refreshTokenRemember');
    Route::post('/register','Auth\RegisterController@register');
    Route::post('/token','UserController@postCheckToken');

    // Route cần Auth
    Route::group(['middleware' => 'auth_api','api'],function(){
        Route::post('/refresh','Auth\LoginController@refresh_token');
        Route::post('/logout','Auth\LoginController@logout');
        Route::get('/profile','UserController@getProfile');
        Route::post('/current-password','UserController@postChangeCurrentPassword');

    });
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});





//API FOR CALLBACK
//Route::any('/charging/callback/{site}', 'Api\ListenCallbackController@getCallback');
//Route::any('/hub/callback/{site}', 'Api\ListenCallbackController@getHubCallback');
//Route::any('/webhook/callback/github','Api\Webhook\GitHubController@getCallback');
//Route::any('/acc/callback/checklogin','Api\V2\Callback\AccCallBack@getcheckLoginCallBack');

require __DIR__.'/api_son.php';

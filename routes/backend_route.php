<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('login', 'HomeController@index')->name('login');
Route::group(array('as' => 'admin.'), function () {

    //Auth::routes(['verify' => true]); //nếu dùng thì thêm middleware check ở route.(->middleware('verified');) và implements MustVerifyEmail trong model user
    //Auth::routes(['verify' => false]);

    //Route::get('login', 'HomeController@index')->name('login');
    Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Admin\Auth\LoginController@login');
    Route::post('logout', 'Admin\Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    if (true) {
        Route::get('register', 'Admin\Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Admin\Auth\RegisterController@register');
    }
    // Password Reset Routes...
    if (true) {
        Route::get('password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.update');
    }
    // Email Verification Routes...
    if (true) {
        Route::get('email/verify', 'Admin\Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'Admin\Auth\VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'Admin\Auth\VerificationController@resend')->name('verification.resend');
    }


});


// 2FA admin
Route::group(array('as' => 'admin.', 'middleware' => ['auth', 'activity_log']), function () {
    Route::get('/2fa', 'Admin\Auth\TwoFactorAuthentication@show2faForm');
    Route::post('/generate2faSecret', 'Admin\Auth\TwoFactorAuthentication@generate2faSecret')->name('generate2faSecret');
    Route::post('/2fa', 'Admin\Auth\TwoFactorAuthentication@enable2fa')->name('enable2fa');
    Route::post('/disable2fa', 'Admin\Auth\TwoFactorAuthentication@disable2fa')->name('disable2fa');

});


Route::group(array('as' => 'admin.', 'middleware' => ['auth', '2fa', 'activity_log']), function () {
    Route::get('/', 'Admin\IndexController@index')->name('index');
});




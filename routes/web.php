<?php

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

Route::get('/login', 'App\Http\Controllers\Auth\AuthController@login')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\AuthController@storeLogin')->name('login.store');
Route::get('/register', 'App\Http\Controllers\Auth\AuthController@register');
Route::post('/register', 'App\Http\Controllers\Auth\AuthController@storeRegister')->name('register.store');
Route::get('/test', 'App\Http\Controllers\CategoryController@index');

Route::group([
    'middleware' => ['auth'],
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::get('/', 'BuyerController@index')->name('buyer.index');
});


Route::group([
    'middleware' => ['auth'],
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'admin'
], function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin');
    Route::get('/change-password', function () {
        return view('auth.passwords.change');
    })->name('auth.password.edit');
    Route::post('/change-password', 'Auth\AuthController@changePassword')->name('auth.password.store');
    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile.edit');

    Route::resource('/category', 'CategoryController');
    Route::resource('/user', 'UserController');
    Route::resource('/product', 'ProductController');
    Route::post('/user/{id}/pass-default', 'UserController@passDefault')->name('password.reset.default');


    Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
});
Route::get('/user', function () {
    return view('user.index');
});
// Forgot password
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->name('forgot.password.create');
Route::post('/forgot-password', 'App\Http\Controllers\Auth\AuthController@forgotPassword')->name('forgot.password.store');
// Reset password
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');
Route::post('/reset-password', 'App\Http\Controllers\Auth\AuthController@resetPassword')->name('password.update');

Route::post('/create-payment', 'App\Http\Controllers\PayPalController@create')->name('paypal.create');
Route::get('/execute-payment', 'App\Http\Controllers\PayPalController@execute')->name('paypal.execute');
Route::get('/cancel-payment', 'App\Http\Controllers\PayPalController@cancel')->name('paypal.cancel');
Route::get('/order', 'App\Http\Controllers\PayPalController@getAll');

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', 'App\Http\Controllers\Auth\AuthController@login')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\AuthController@storeLogin')->name('login.store');
Route::get('/register', 'App\Http\Controllers\Auth\AuthController@storeRegister');
Route::get('/test', 'App\Http\Controllers\CategoryController@index');

Route::group([
    'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'admin'
], function () {
    Route::get('/admin', function () {
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


    Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
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

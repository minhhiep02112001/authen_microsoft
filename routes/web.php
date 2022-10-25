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

Route::group([
    'prefix' => 'login'
], function () {
    Route::get('/', [\App\Http\Controllers\Client\AuthController::class, 'login'])->name('login');
    Route::post('/', [\App\Http\Controllers\Client\AuthController::class, 'checkLogin'])->name('post.login');
    Route::get('/{attr}', [\App\Http\Controllers\Client\AuthSocialiteController::class, 'login'])->name('login.socialite');
    Route::get('/{attr}/callback', [\App\Http\Controllers\Client\AuthSocialiteController::class, 'callback']);
});

Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/change-password', [\App\Http\Controllers\HomeController::class, 'index'])->name('account.change.password');
    Route::post('/logout', [\App\Http\Controllers\Client\AuthController::class, 'logout'])->name('logout');
});

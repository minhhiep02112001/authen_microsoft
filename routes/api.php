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

Route::post('search-account', [\App\Http\Controllers\Api\AuthController::class, 'searchAccount'])->name('search.account');

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('user', [App\Http\Controllers\Api\UserController::class, 'user']);
    Route::post('profile/change-password', [App\Http\Controllers\Api\UserController::class, 'changePassword']);
});

Route::group(['prefix' => 'auth'], function () {
    /// Luồng đăng ký
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('verify-register', [\App\Http\Controllers\Api\AuthController::class, 'verifyRegister']);
    Route::post('resend-otp', [\App\Http\Controllers\OtpController::class, 'resendOtp']);
    Route::post('forgot-password', [\App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
    Route::post('verify-forgot-password', [\App\Http\Controllers\Api\AuthController::class, 'postForgotPassword']);
});


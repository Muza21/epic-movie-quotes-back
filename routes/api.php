<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\VerifyEmailController;
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

Route::post('/signup', [AuthController::class,'register'])->name('signup');
Route::post('/login', [AuthController::class,'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth')->name('logout');
Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.auth')->name('me');

Route::post('/email/verify/{id}/{token}', [VerifyEmailController::class, 'verifyEmail'])->name('verification.verify');
Route::get('/redirect', [GoogleAuthController::class,'googleRedirect'])->name('google.redirect');
Route::get('/callback', [GoogleAuthController::class,'googleCallback'])->name('google.callback');

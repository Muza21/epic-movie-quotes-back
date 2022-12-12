<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\QuotesController;
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
Route::controller(AuthController::class)->group(function () {
    Route::post('/signup', 'register')->name('signup');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->middleware('jwt.auth')->name('logout');
    Route::get('/check-user', 'checkAuthentication')->middleware('jwt.auth')->name('check.user');
    Route::get('/current-user', 'currentUserData')->middleware('jwt.auth')->name('current.user');
});

Route::post('/email/verify/{id}/{token}', [VerifyEmailController::class, 'verifyEmail'])->name('verification.verify');

Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('/redirect', 'googleRedirect')->name('google.redirect');
    Route::get('/callback', 'googleCallback')->name('google.callback');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::post('/reset-password', 'update')->name('password.update');
});

Route::controller(MoviesController::class)->group(function () {
    Route::post('/movie', 'store')->middleware('jwt.auth')->name('add.movie');
    Route::patch('/movie/{movie}', 'update')->middleware('jwt.auth')->name('add.movie');
    Route::post('/movie/{movie}', 'destroy')->middleware('jwt.auth')->name('delete.movie');
    Route::get('/movielist', 'movies')->middleware('jwt.auth')->name('movie.list');
    Route::get('/movie-description/{movie}', 'loadMovie')->middleware('jwt.auth')->name('load.movie');
});

Route::get('/genres', [GenreController::class,'genres'])->middleware('jwt.auth')->name('genre.list');

Route::controller(QuotesController::class)->group(function () {
    Route::post('/quote', 'store')->middleware('jwt.auth')->name('add.quote');
    Route::patch('/quote/{quote}', 'update')->middleware('jwt.auth')->name('edit.quote');
    Route::post('/quote/{quote}', 'destroy')->middleware('jwt.auth')->name('delete.quote');
    Route::get('/quotes', 'quotes')->middleware('jwt.auth')->name('quotes.list');
    Route::get('/load-quote/{quote}', 'loadQuote')->middleware('jwt.auth')->name('load.quote');
});

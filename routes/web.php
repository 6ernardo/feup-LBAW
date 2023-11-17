<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FeedController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::redirect('/', '/login');

//Feed
Route::controller(FeedController::class)->group(function () {
    Route::get('/feed', 'index')->name('feed');
});

// User
Route::controller(UserController::class)->group(function () {
    Route::get('/user/{id}', 'show');
    Route::get('/user/{id}/edit', 'showEditForm');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

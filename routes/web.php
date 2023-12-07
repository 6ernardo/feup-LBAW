<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FeedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommentQuestionController;
use App\Http\Controllers\CommentAnswerController;

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

// Feed
Route::controller(FeedController::class)->group(function () {
    Route::get('/feed', 'index')->name('feed');
});

// User
Route::controller(UserController::class)->group(function () {
    Route::get('/user/{id}', 'show');
    Route::get('/user/{id}/edit', 'showEditForm');
    Route::put('/user/{id}/edit', 'editProfile');
    Route::get('/user/{id}/questions', 'showQuestions');
    Route::get('/user/{id}/answers', 'showAnswers');
});

// Admin
Route::controller(AdminController::class)->group(function () {
    Route::get('/manageusers', 'showManageUsers');
    Route::get('/manageusers/create', 'showCreateUser');
    Route::post('/manageusers/create', 'createUser');
    Route::get('/search/users','search');
});

//Question
Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions/create', 'create')->name('questions.create');
    Route::post('/questions', 'store')->name('questions.store');
    Route::get('/questions/{id}','show')->name('questions.show');
    Route::get('/questions/{id}/edit', 'showEdit');
    Route::put('/questions/{id}/edit', 'editQuestion');
    Route::delete('/questions/{id}/delete', 'deleteQuestion');
    Route::get('/search','searchList')->name('searchQuestionResults');
    Route::get('/searchQuestionForm','searchForm')->name('searchQuestionForm');
});

//Answer
Route::controller(AnswerController::class)->group(function () {
    Route::post('questions/{id}/answer/create', 'create');
    Route::delete('/answers/{id}/delete', 'delete');
    Route::get('/answers/{id}/edit', 'showEdit');
    Route::put('/answers/{id}/edit', 'edit');
});

//Question Comments
Route::controller(CommentQuestionController::class)->group(function() {
    Route::post('questions/{id}/comment/create', 'create');
    Route::delete('/commentquestion/{id}/delete', 'delete');
    Route::get('/commentquestion/{id}/edit', 'showEdit');
    Route::put('/commentquestion/{id}/edit', 'edit');
});

//Answer Comments
Route::controller(CommentAnswerController::class)->group(function() {
    Route::post('questions/{question_id}/answer/{answer_id}/comment/create', 'create');
    Route::delete('/commentanswer/{id}/delete', 'delete');
    Route::get('/commentanswer/{id}/edit', 'showEdit');
    Route::put('/commentanswer/{id}/edit', 'edit');
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
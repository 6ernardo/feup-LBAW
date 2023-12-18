<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FeedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentQuestionController;
use App\Http\Controllers\CommentAnswerController;
use App\Http\Controllers\StaticPageController;

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
Route::redirect('/', '/feed');

// Static Pages
Route::controller(FeedController::class)->group(function () {
    Route::get('/feed', 'index')->name('feed');
});

// Feed
Route::controller(StaticPageController::class)->group(function () {
    Route::get('/aboutus', 'aboutus');
    Route::get('/mainfeatures', 'mainfeatures');
    Route::get('/contacts', 'contacts');
});

// User
Route::controller(UserController::class)->group(function () {
    Route::get('/user/{id}', 'show');
    Route::get('/user/{id}/edit', 'showEditForm');
    Route::put('/user/{id}/edit', 'editProfile');
    Route::get('/user/{id}/questions', 'showQuestions');
    Route::get('/user/{id}/answers', 'showAnswers');
    Route::delete('/user/{id}/delete', 'delete');
    Route::post('/tag/{id}/follow', 'follow_tag');
    Route::post('/tag/{id}/unfollow', 'unfollow_tag');
    Route::post('/questions/{id}/follow', 'follow_question');
    Route::post('/questions/{id}/unfollow', 'unfollow_question');
});

// Admin
Route::controller(AdminController::class)->group(function () {
    Route::get('/admindashboard', 'showDashboard');
    Route::get('/manageusers/create', 'showCreateUser');
    Route::post('/manageusers/create', 'createUser');
    Route::delete('/manageusers/delete/{id}', 'deleteUser');
    Route::get('/search/users','search');
    Route::post('/manageusers/block/{id}', 'blockUser');
    Route::post('/manageusers/unblock/{id}', 'unblockUser');
    Route::put('/manageusers/changerole/{id}', 'changeRole');
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

//Tag
Route::controller(TagController::class)->group(function() {
    Route::get('/tags', 'list');
    Route::get('/tags/create', 'showCreateTag');
    Route::post('/tags/create', 'createTag');
    Route::get('/tags/{id}/edit', 'showEdit');
    Route::put('/tags/{id}/edit', 'editTag');
    Route::delete('/tags/{id}/delete', 'deleteTag');
    Route::get('/tags/{id}','show')->name('tags.show');
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
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;


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


// HOME
Route::redirect('/', '/home');
//Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('guest');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// PROFILE
Route::get('/profile', [HomeController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/profile/{id}', [UserController::class, 'index'])->where('id', '[0-9]+');
Route::get('/profile/edit/{id}', [UserController::class, 'edit']);
Route::post('/profile/edit/{id}', [UserController::class, 'update']);
Route::get('/profile/articles/{id}', [UserController::class, 'showArticles'])->where('id', '[0-9]+');



// ADMIN
Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('auth', 'admin');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/profile_admin/{id}', [AdminController::class, 'show_profile'])->where('id', '[0-9]+');
Route::get('/admin-profile/edit', [AdminController::class, 'edit_profile']);
Route::post('/admin-profile/edit', [AdminController::class, 'update_profile']);
Route::get('/search-user', [AdminController::class, 'search_user']);

// AUTHENTICATION
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


Route::get('sidebar',[SidebarController::class,'showSidebar']);


// Article page


Route::get('/articles/{articleId}', [ArticleController::class, 'getArticleInformation']);
Route::get('article', [ArticleController::class, 'showArticles']);
Route::get('/article/edit/{articleId}', [ArticleController::class, 'editArticle']);
Route::post('/article/edit/{articleId}', [ArticleController::class, 'updateArticle']);
Route::delete('/article/delete/', [ArticleController::class, 'deleteArticle']);
Route::get('/article/create', [ArticleController::class, 'createArticlePage']);
Route::post('/article/create-confirm', [ArticleController::class, 'newArticle']);
Route::get('/search-user-post', [ArticleController::class, 'search_user_articles']);
// web.php

// web.php
//Route::get('/home/{category?}', 'HomeController@index')->name('home');
// web.php
Route::get('/articles/show/{category?}', 'ArticleController@showArticles')->name('articles.show');



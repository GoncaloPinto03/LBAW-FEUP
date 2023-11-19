<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Article\ArticleController;

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


// Home route accessible to everyone
Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


// Article page


Route::get('/articles/{articleId}', [ArticleController::class, 'getArticleInformation']);
/*Route::controller(ArticleController::class)->group(function () {
    Route::get('/article', 'showArticle') ->name('article');
    //Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    /*Route::post('article/new', 'create');
    Route::get('/article/{id}', function () {
        return view('pages.article');
    });
});
*/
/*Route::get('/article/{id}',function(){
    return view('pages.article');
});
Route::put('/article/{id}/edit', 'ArticleController@updateArticle');
Route::delete('/article/{id}/delete', 'articleController@delete');

Route::get('/new',function(){
    return view('pages.articleNew');
});
Route::post('/new','ArticleController@create');*/

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
use App\Http\Controllers\ArticleVoteController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TagController;



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
Route::get('home/{topic_id?}', [HomeController::class, 'index'])->name('home');

// PROFILE
Route::get('/profile', [HomeController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/profile/{id}', [UserController::class, 'index'])->where('id', '[0-9]+');
Route::get('/profile/edit/{id}', [UserController::class, 'edit']);
Route::post('/profile/edit/{id}', [UserController::class, 'update']);
Route::get('/profile/articles/{id}', [UserController::class, 'showArticles'])->where('id', '[0-9]+');

// ADMIN
Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('auth:admin');
Route::get('/admin/users', [AdminController::class, 'usersPage'])->name('admin.users')->middleware('auth:admin');
Route::get('/admin/topics', [AdminController::class, 'topicsPage'])->name('admin.topics')->middleware('auth:admin');
Route::get('/admin/topicproposals', [AdminController::class, 'topicProposalsPage'])->name('admin.topicproposals')->middleware('auth:admin');
Route::post('/admin/topicproposals/{id}/accept', [AdminController::class , 'acceptTopicProposal'])->name('admin.topicproposals.accept')->middleware('auth:admin');
Route::post('/admin/topicproposals/{id}/deny', [AdminController::class, 'denyTopicProposal'])->name('admin.topicproposals.deny')->middleware('auth:admin');


Route::get('/profile_admin/{id}', [AdminController::class, 'show_profile'])->where('id', '[0-9]+');
Route::get('/admin-profile/edit', [AdminController::class, 'edit_profile']);
Route::post('/admin-profile/edit', [AdminController::class, 'update_profile']);
Route::get('/search-user', [AdminController::class, 'search_user']);
Route::post('/admin/block-user/{id}', [AdminController::class, 'blockUser'])->name('admin.blockUser')->where('id', '[0-9]+');
Route::get('/admin/unblock/{id}', [AdminController::class, 'unblockUser'])->name('admin.users.unblock')->where('id', '[0-9]+');



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

Route::post('/articles/{articleId}/like', [ArticleVoteController::class, 'like'])->middleware('auth');
Route::post('/articles/{articleId}/unlike', [ArticleVoteController::class, 'unlike'])->middleware('auth');
Route::post('/articles/{articleId}/dislike', [ArticleVoteController::class, 'dislike'])->middleware('auth');
Route::post('/articles/{articleId}/undislike', [ArticleVoteController::class, 'undislike'])->middleware('auth');

// web.php

// web.php
//Route::get('/home/{category?}', 'HomeController@index')->name('home');
// web.php
Route::get('/articles/show/{category?}', 'ArticleController@showArticles')->name('articles.show');

// COMMENTS
Route::post('/comment/create', [CommentController::class, 'createComment'])->name('comment.create');
Route::delete('/comment/delete', [CommentController::class, 'deleteComment'])->name('comment.delete');

// TOPICS
Route::get('/topic/proposal', [TopicController::class, 'showProposalForm'])->name('topic.propose');
Route::post('/topic/proposal', [TopicController::class, 'submitProposal']);
Route::post('/topic/{id}/follow', [TopicController::class, 'followTopic'])->middleware('auth');

// TAGS
Route::get('/tag/{tag_id}', [TagController::class, 'tagArticles']);
Route::post('/tag/{tag_id}/follow', [TagController::class, 'followTag'])->middleware('auth')->name('tag.follow');

//ABOUT
Route::get('/about', [AboutController::class, 'about'])->name('about');



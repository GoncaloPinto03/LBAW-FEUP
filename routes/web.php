<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;

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

Route::get('/profile/{id}', [UsersController::class, 'index'])->where('id', '[0-9]+');
Route::get('/profile/edit', [UsersController::class, 'edit']);
Route::post('/profile/edit', [UsersController::class, 'update']);
//LEMBRAR ERRO EM LINHA 259 DE CREATE_DB.SQL
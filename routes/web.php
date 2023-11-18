<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('guest');

// PROFILE
Route::get('/profile', [HomeController::class, 'profile'])->name('profile')->middleware('auth');

// ADMIN
Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('auth', 'admin');

// AUTHENTICATION
Route::get('/login', 'showLoginForm')->name('login');
Route::post('/login', 'authenticate');
Route::get('/logout', 'logout')->name('logout');
Route::get('/register', 'showRegistrationForm')->name('register');
Route::post('/register', 'register');


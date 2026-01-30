<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\PostsController;
use App\Http\Controllers\web\CoursesController;
use App\Http\Controllers\web\MailController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/home', 'pages.home')->name('home');

Route::view('/about', 'pages.about')->name('about');

Route::resource('posts', PostsController::class);

Route::get('/courses', [CoursesController::class, 'index'])->name('courses');
Route::post('/courses/{course}/reserve', [CoursesController::class, 'reserve'])->name('courses.reserve');

Route::view('/contact', 'pages.contact')->name('mail.index');
Route::post('/contact', [MailController::class, 'send'])->name('mail.send');

// Auth routes
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [App\Http\Controllers\web\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\web\AuthController::class, 'logout'])->name('logout');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [App\Http\Controllers\web\AuthController::class, 'register'])->name('register.post');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\PostController;
use App\Http\Controllers\web\CoursesController;
use App\Http\Controllers\web\MailController;
use App\Http\Controllers\web\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/home', 'pages.home')->name('home');

Route::view('/about', 'pages.about')->name('about');


// Course routes
Route::get('/course', [CoursesController::class, 'index'])->name('course');
Route::post('/courses/{course}/reserve', [CoursesController::class, 'reserve'])->name('courses.reserve');

// Contact form routes
Route::view('/contact', 'pages.contact')->name('mail.index');
Route::middleware('auth')->group(function () { 
    Route::post('/contact', [MailController::class, 'send'])->name('mail.send');
});

// Auth routes
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [App\Http\Controllers\web\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\web\AuthController::class, 'logout'])->name('logout');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [App\Http\Controllers\web\AuthController::class, 'register'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::resource('post', PostController::class);
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

});
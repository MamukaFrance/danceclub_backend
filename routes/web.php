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

Route::get('/contact', [MailController::class, 'index'])->name('mail.index');
Route::post('/contact', [MailController::class, 'send'])->name('mail.send');

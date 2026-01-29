<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CoursesController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/home', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Route::get('/posts', function () {
//     return view('pages.posts');
// })->name('posts');

// Route::resource('posts', PostsController::class);
Route::get('posts', [PostsController::class, 'index'])->name('posts');

// Route::get('create-post', [PostsController::class, 'create'])->name('post.create');
// Route::post('create-post', [PostsController::class, 'store'])->name('create-post.store');
// Route::delete('delete-post/{id}', [PostsController::class, 'destroy'])->name('delete-post');

Route::resource('posts', PostsController::class);


Route::get('courses', [CoursesController::class, 'index'])->name('courses');
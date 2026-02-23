<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\PostController;
use App\Http\Controllers\web\CoursesController;
use App\Http\Controllers\web\CourseController;
use App\Http\Controllers\web\MailController;
use App\Http\Controllers\web\ProfileController;
use App\Http\Controllers\web\EventController;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\EventParticipantController;

// Welcome route


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/home', 'pages.home')->name('home');

Route::view('/about', 'pages.about')->name('about');


// Course routes
// Route::get('/course', [CourseController::class, 'index'])->name('course.index');

Route::post('/courses/{course}/reserve', [CoursesController::class, 'reserve'])->name('courses.reserve');

// Contact form routes
Route::view('/contact', 'pages.contact')->name('mail.index');
Route::middleware('auth')->group(function () { 
    Route::post('/contact', [MailController::class, 'send'])->name('mail.send');
});

// Auth routes
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::resource('event', EventController::class);
    Route::post('/event/{event}/participe', [EventController::class, 'participe'])->name('event.participe');
    Route::resource('post', PostController::class);
    Route::resource('course', CourseController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

Route::resource('eventparticipant', EventParticipantController::class)
    ->parameters(['eventparticipant' => 'eventParticipant']);

Route::post('/events/{event}/register', [EventParticipantController::class, 'register'])
    ->name('eventparticipant.register');

Route::post('/participants/{participant}/cancel', [EventParticipantController::class, 'cancel'])
    ->name('eventparticipant.cancel');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\AuthController;

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Courses routes
Route::post('/courses/{course}/reserve', [CourseController::class, 'reserveCourse']);

use App\Http\Controllers\Api\ReserveController;

//Route::middleware('auth:sanctum')->get('/my-reservations', [ReserveController::class, 'myReservations']);
Route::apiResource('my-reservations', ReserveController::class);


//Route::get('/courses', [CourseController::class, 'index']);
Route::apiResource('courses', CourseController::class);

Route::apiResource('reserves', ReserveController::class);

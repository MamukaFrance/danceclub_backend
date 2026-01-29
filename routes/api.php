<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReserveController;

// Auth routes (publiques)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public courses
Route::apiResource('courses', CourseController::class);

// Protected routes - authentification requise
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/reservations', ReserveController::class);
    Route::get('/profile', [UserController::class, 'show']);
    Route::post('/courses/{course}/reserve', [CourseController::class, 'reserveCourse']);
});

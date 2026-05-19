<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InstructorRequestController;
use App\Http\Controllers\InstructorController;
use Illuminate\Support\Facades\Route;


// Protected Instructor Routes
Route::middleware(['auth:sanctum', 'role:instructor'])->group(function () {
    
    Route::get('/dashboard', [InstructorController::class, 'dashboard']);
    Route::get('/my-courses', [InstructorController::class, 'courses']);
    Route::get('/my-courses/{slug}', [InstructorController::class, 'courseDetails']);
    Route::get('/reviews', [InstructorController::class, 'reviews']);

    //courses management
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{course:slug}', [CourseController::class, 'update']);
    Route::delete('/courses/{course:slug}', [CourseController::class, 'destroy']);

    //sections management
    Route::post('/sections', [SectionController::class, 'store']);
    Route::put('/sections/{sections:slug}', [SectionController::class, 'update']);
    Route::delete('/sections/{sections:slug}', [SectionController::class, 'destroy']);

    //lessons management
    Route::post('/lessons', [LessonController::class, 'store']);
    Route::put('lessons/{lesson:slug}', [LessonController::class, 'update']);
    Route::delete('lessons/{lesson:slug}', [LessonController::class, 'destroy']);
});

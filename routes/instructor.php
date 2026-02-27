<?php

use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Lesson\LessonController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\instructor\InstructorRequestController;
use Illuminate\Support\Facades\Route;




//Instructor Routes



//courses
Route::post('/courses', [CourseController::class, 'store']);
Route::put('/courses/{course:slug}', [CourseController::class, 'update']);
Route::delete('/courses/{course:slug}' , [CourseController::class, 'destroy']);


//sections
Route::post('/sections', [SectionController::class, 'store']);
Route::put('/sections/{sections:slug}', [SectionController::class, 'update']);
Route::delete('/sections/{sections:slug}' , [SectionController::class, 'destroy']);

//lessons
Route::post('/lessons', [LessonController::class , 'store']);
Route::put('lessons/{lesson:slug}', [LessonController::class , 'update']);
Route::delete('lessons/{lesson:slug}',[LessonController::class , 'destroy']);




//instructor Reuests
Route::post('/instructor-requests',[InstructorRequestController::class,'store']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Course\CourseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::get('/courses', [CourseController::class,"index"]);
Route::post('/courses', [CourseController::class,"store"]);
Route::get('/courses/{id}', [CourseController::class,"show"]);

<?php


use App\Http\Controllers\Lesson\LessonController;

use Illuminate\Support\Facades\Route;







Route::get('/lessons', [LessonController::class , 'index']);
Route::post('/lessons', [LessonController::class , 'store']);
Route::get('lessons/{lesson:slug}', [LessonController::class , 'show']);
Route::put('lessons/{lesson:slug}', [LessonController::class , 'update']);
Route::delete('lessons/{lesson:slug}',[LessonController::class , 'destroy']);






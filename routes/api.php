<?php

use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\Lesson\LessonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//section
Route::prefix('sections')->group(function () {
 Route::get('/', [SectionController::class , 'index']);
Route::post('/', [SectionController::class , 'store']);
Route::get('/{section}', [SectionController::class , 'show']);
Route::put('/{section}', [SectionController::class , 'update']);
Route::delete('/{section}', [SectionController::class , 'destroy']);
});
 
// Lesson
Route::prefix('lessons')->group(function () {

Route::get('/', [LessonController::class , 'index']);
Route::post('/', [LessonController::class , 'store']);
Route::get('/{lesson}', [LessonController::class , 'show']);
Route::put('/{lesson}', [LessonController::class , 'update']);
Route::delete('/{lesson}',[LessonController::class , 'destroy']);
});






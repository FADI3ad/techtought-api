<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Course\CourseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




//Auth
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);



//Categories
Route::get('/categories', [CategoryController::class, 'index']); // dont forget do this
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{category:slug}', [CategoryController::class, 'show']);
Route::put('/categories/{category:slug}', [CategoryController::class, 'update']);
Route::delete('/categories/{category:slug}', [CategoryController::class, 'destroy']);



//SubCategories
Route::get('/subcategories', [SubCategoryController::class, 'index']); // dont forget do this
Route::post('/subcategories', [SubCategoryController::class, 'store']);
Route::get('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'show']);
Route::put('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'update']);
Route::delete('/subcategories/{subcategory:slug}' , [SubCategoryController::class, 'destroy']);


//courses
Route::get('/courses', [CourseController::class, 'index']); // dont forget do this
Route::post('/courses', [CourseController::class, 'store']);
Route::get('/courses/{course:slug}', [CourseController::class, 'show']);
Route::put('/courses/{course:slug}', [CourseController::class, 'update']);
Route::delete('/courses/{course:slug}' , [CourseController::class, 'destroy']);



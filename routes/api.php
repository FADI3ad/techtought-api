<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Lesson\LessonController;
use App\Http\Controllers\Section\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




//Auth
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);



//Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/navbar',[CategoryController::class , 'navbarCategories']);
Route::get('/categories/{category:slug}', [CategoryController::class, 'show']);
Route::get('/categories/{category:slug}/subcategories', [CategoryController::class, 'showWithSubcategories']);



//SubCategories
Route::get('/subcategories', [SubCategoryController::class, 'index']);
Route::get('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'show']);
Route::get('/subcategories/{subcategory:slug}/courses', [SubCategoryController::class, 'showWithCourses']);




//courses
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{course:slug}', [CourseController::class, 'show']);



//sections
Route::get('/sections', [SectionController::class, 'index']);
Route::get('/sections/{sections:slug}', [SectionController::class, 'show']);


//lessons
Route::get('/lessons', [LessonController::class , 'index']);
Route::get('lessons/{lesson:slug}', [LessonController::class , 'show']);





require_once __DIR__.'/admin.php';
require_once __DIR__.'/instructor.php';
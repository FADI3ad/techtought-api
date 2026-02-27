<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\instructor\InstructorRequestController;
use App\Http\Controllers\Lesson\LessonController;
use App\Http\Controllers\Section\SectionController;
use Illuminate\Support\Facades\Route;







// Admin Routes


Route::prefix('admin')->group(function () {

    // Admin Auth
    Route::post('/login', [AdminAuthController::class, 'login']);


    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

        //Categories
        Route::get('/categories', [CategoryController::class, 'index']); //done
        Route::post('/categories', [CategoryController::class, 'store']); //done
        Route::get('/categories/{category:slug}', [CategoryController::class, 'show']); // done
        Route::put('/categories/{category:slug}', [CategoryController::class, 'update']); //done
        Route::delete('/categories/{category:slug}', [CategoryController::class, 'destroy']); //done
        Route::get('/categories/{category:slug}/subcategories', [CategoryController::class, 'showWithSubcategories']);


        //SubCategories
        Route::get('/subcategories', [SubCategoryController::class, 'index']);
        Route::post('/subcategories', [SubCategoryController::class, 'store']);
        Route::get('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'show']);
        Route::put('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'update']);
        Route::delete('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'destroy']);




        //courses
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{course:slug}', [CourseController::class, 'show']);
        Route::delete('/courses/{course:slug}', [CourseController::class, 'destroy']);



        //sections
        Route::get('/sections', [SectionController::class, 'index']);
        Route::get('/sections/{sections:slug}', [SectionController::class, 'show']);
        Route::delete('/sections/{sections:slug}', [SectionController::class, 'destroy']);



        //lessons
        Route::get('/lessons', [LessonController::class, 'index']);
        Route::get('lessons/{lesson:slug}', [LessonController::class, 'show']);
        Route::delete('lessons/{lesson:slug}', [LessonController::class, 'destroy']);



        //instructor Reuests
        Route::get('/instructor-requests',[InstructorRequestController::class, 'index']);
        Route::post('/instructor-requests/{instructoraccountrequest:slug}/change-status' , [InstructorRequestController::class , 'changeStatus']);
        Route::get('/instructor-requests/{InstructorRequest:slug}',[InstructorRequestController::class, 'show']);
        Route::delete('/instructor-requests/{InstructorRequest:slug}',[InstructorRequestController::class, 'destroy']);

    });
});

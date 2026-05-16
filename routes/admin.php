<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\InstructorRequestController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;







// Admin Routes
Route::prefix('admin')->group(function () {

    // Admin Auth
    // Route removed. Use unified /api/login endpoint.


    Route::middleware(['auth:sanctum', 'role:admin'])->group(callback: function () {




        //Categories
        Route::get('/categories', [CategoryController::class, 'index']);  // Tested and working fine
        Route::post('/categories', [CategoryController::class, 'store']); // Tested and working fine
        Route::get('/categories/{category:slug}', [CategoryController::class, 'show']); // Tested and working fine
        Route::put('/categories/{category:slug}', [CategoryController::class, 'update']); // Tested and working fine
        Route::delete('/categories/{category:slug}', [CategoryController::class, 'destroy']); // Tested and working fine
        Route::get('/categories/{category:slug}/subcategories', [CategoryController::class, 'showWithSubcategories']);


        //SubCategories
        Route::get('/subcategories', [SubCategoryController::class, 'index']); // Tested and working fine
        Route::post('/subcategories', [SubCategoryController::class, 'store']); // Tested and working fine
        Route::get('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'show']); // Tested and working fine
        Route::put('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'update']);
        Route::delete('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'destroy']); // Tested and working fine




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


        //reviews (admin)
        Route::get('/reviews', [ReviewController::class, 'index']);
        Route::get('/reviews/{review}', [ReviewController::class, 'show']);
        Route::put('/reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);


        //comments (admin)
        Route::get('/comments', [CommentController::class, 'index']);
        Route::get('/comments/{comment}', [CommentController::class, 'show']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);



        //instructor Requests
        Route::get('/instructor-requests', [InstructorRequestController::class, 'index']);
        Route::get('/instructor-requests/{instructorAccountRequest:slug}', [InstructorRequestController::class, 'show']);
        Route::delete('/instructor-requests/{instructorAccountRequest}', [InstructorRequestController::class, 'destroy']);
        Route::post('/instructor-requests/{id}/approve', [AdminController::class, 'approve']);

        // Testimonials (admin)
        Route::get('/testimonials', [TestimonialController::class, 'adminIndex']);
        Route::patch('/testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggleVisibility']);
        Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);
    });
});

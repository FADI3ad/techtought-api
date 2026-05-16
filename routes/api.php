<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FavoriteCourseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




//Auth
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');


//Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/navbar',[CategoryController::class , 'navbarCategories']);
Route::get('/categories/{category:slug}', [CategoryController::class, 'show']);
Route::get('/categories/{category:slug}/subcategories', [CategoryController::class, 'showWithSubcategories']);
Route::get('/categories/{category:slug}/courses', [CategoryController::class, 'showWithLatestSixCourses']);
Route::get('/categories/{category:slug}/all-courses', [CategoryController::class, 'showWithAllCourses']);



//SubCategories
Route::get('/subcategories', [SubCategoryController::class, 'index']);
Route::get('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'show']);
Route::get('/subcategories/{subcategory:slug}/courses', [SubCategoryController::class, 'showWithCourses']);




//courses
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{course:slug}', [CourseController::class, 'show']);
Route::get('/courses/{course:slug}/sections', [CourseController::class, 'showWithSectionsAndLessons']);
Route::get('/top-rated-courses', [CourseController::class, 'topRated']);


//sections
Route::get('/sections', [SectionController::class, 'index']);
Route::get('/sections/{sections:slug}', [SectionController::class, 'show']);


//lessons
Route::get('/lessons', [LessonController::class , 'index']);
Route::get('lessons/{lesson:slug}', [LessonController::class , 'show']);


//reviews (public)
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);


//comments (public)
Route::get('/comments', [CommentController::class, 'index']);
Route::get('/comments/{comment}', [CommentController::class, 'show']);
Route::get('/courses/{course:slug}/comments', [CommentController::class, 'courseComments']);

// Subscription
Route::post('/subscribe', [SubscriptionController::class, 'store']);

// Testimonials
Route::get('/testimonials', [TestimonialController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store']);

    // Enrollments
    Route::get('/my-learning', [EnrollmentController::class, 'index']);
    Route::post('/enroll', [EnrollmentController::class, 'store']);

    // Favorites
    Route::get('/favorites', [FavoriteCourseController::class, 'index']);
    Route::post('/favorites', [FavoriteCourseController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteCourseController::class, 'destroy']);

    // Testimonials
    Route::post('/testimonials', [TestimonialController::class, 'store']);
});





require_once __DIR__.'/admin.php';

Route::prefix('instructor')->group(function () {
    require_once __DIR__.'/instructor.php';
});

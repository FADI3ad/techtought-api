<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use Illuminate\Support\Facades\Route;






// Admin Routes
Route::post('/login', [AdminAuthController::class, 'login'])->prefix('admin');





Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {


    //Categories
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category:slug}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category:slug}', [CategoryController::class, 'destroy']);


    //SubCategories
    Route::post('/subcategories', [SubCategoryController::class, 'store']);
    Route::put('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'update']);
    Route::delete('/subcategories/{subcategory:slug}', [SubCategoryController::class, 'destroy']);
});

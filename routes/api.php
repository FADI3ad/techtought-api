<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Category\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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







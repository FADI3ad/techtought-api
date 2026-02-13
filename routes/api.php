<?php

use App\Http\Controllers\Section\SectionController as SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/section-store', [SectionController::class , 'store']);
Route::get('/section-index', [SectionController::class , 'index']);
Route::get('/section-show/{section}', [SectionController::class , 'show']);
Route::put('/section-update/{section}', [SectionController::class , 'update']);
Route::delete('/section-destroy/{section}', [SectionController::class , 'destroy']);






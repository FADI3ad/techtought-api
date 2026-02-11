<?php

use App\Http\Controllers\Section\SectionController as SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::get('/section-store', [SectionController::class , 'store']);
Route::get('/section-update', [SectionController::class , 'udate']);




<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomepageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::get('/homepages', [HomepageController::class, 'index']);

// http://127.0.0.1:8000/api/homepages 

route::get('/locations', [HomepageController::class, 'location']);

// http://127.0.0.1:8000/api/locations
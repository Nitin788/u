<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('admin.adddestination');
// });

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // resource
    Route::resource('homepages', controller: HomepageController::class);
    Route::resource('countries', controller: CountryController::class);
    Route::resource('destinations', controller: DestinationController::class);
    Route::resource('hotels', controller: HotelController::class);
    //  End resource

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
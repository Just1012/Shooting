<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\HomeSliderController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('home')->group(function () {
        Route::get('/index', [HomeSliderController::class, 'index'])->name('slider.index');
        Route::get('/dataTable', [HomeSliderController::class, 'getSlider'])->name('slider.dataTable');
        Route::get('/addSlider', [HomeSliderController::class, 'addSlider'])->name('slider.addSlider');
        Route::post('/storeSlider', [HomeSliderController::class, 'storeSlider'])->name('slider.store');
        Route::get('/editSlider/{id}', [HomeSliderController::class, 'editSlider'])->name('slider.edit');
        Route::post('/updateSlider/{id}', [HomeSliderController::class, 'updateSlider'])->name('slider.update');
        Route::get('/deleteSlider/{id}', [HomeSliderController::class, 'deleteSlider'])->name('slider.delete');
        Route::get('/updateStatus/{homeSlider}', [HomeSliderController::class, 'updateStatus'])->name('slider.status');

    });

    });

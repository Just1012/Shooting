<?php

use App\Http\Controllers\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\HomeSliderController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\SystemInfoController;
use App\Http\Controllers\Dashboard\SystemSetupController;
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

    Route::prefix('system-setup')->group(function () {
        Route::get('/editSystemSetup/edit', [SystemSetupController::class, 'editSystemSetup'])->name('editSystemSetup');
        Route::post('/updateSystemSetup/update', [SystemSetupController::class, 'updateSystemSetup'])->name('updateSystemSetup');
    });

    Route::prefix('system-info')->group(function () {
        Route::get('/editSystemInfo/edit', [SystemInfoController::class, 'editSystemInfo'])->name('editSystemInfo');
        Route::post('/updateSystemInfo/update', [SystemInfoController::class, 'updateSystemInfo'])->name('updateSystemInfo');
    });

    Route::prefix('category')->group(function () {
        Route::get('/index', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/dataTable', [CategoryController::class, 'getCategory'])->name('category.dataTable');
        Route::get('/addCategory', [CategoryController::class, 'addCategory'])->name('category.addCategory');
        Route::post('/storeCategory', [CategoryController::class, 'storeCategory'])->name('Category.store');
        Route::get('/editCategory/{id}', [CategoryController::class, 'editCategory'])->name('Category.edit');
        Route::post('/updateCategory/{id}', [CategoryController::class, 'updateCategory'])->name('Category.update');
        Route::get('/updateStatus/{category}', [CategoryController::class, 'updateStatus'])->name('category.status');

    });

    Route::prefix('partner')->group(function () {
        Route::get('/index', [PartnerController::class, 'index'])->name('partner.index');
        Route::get('/dataTable', [PartnerController::class, 'getPartner'])->name('partner.dataTable');
        Route::get('/addPartner', [PartnerController::class, 'addPartner'])->name('partner.addPartner');
        Route::post('/storePartner', [PartnerController::class, 'storePartner'])->name('partner.store');
        Route::get('/editPartner/{id}', [PartnerController::class, 'editPartner'])->name('partner.edit');
        Route::post('/updatePartner/{id}', [PartnerController::class, 'updatePartner'])->name('partner.update');
        Route::get('/deletePartner/{id}', [PartnerController::class, 'deletePartner'])->name('partner.delete');
        Route::get('/updateStatus/{partner}', [PartnerController::class, 'updateStatus'])->name('partner.status');
    });

    });

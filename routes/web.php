<?php

use App\Http\Controllers\Dashboard\HiringController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserRegisterController;
use App\Http\Controllers\Frontend\HomeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


require __DIR__ . '/auth.php';



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () { //...
        Route::get('/', [HomeController::class, 'home'])->name('home');
        Route::get('/filter-brands', [HomeController::class, 'getAllBrands']);
        Route::get('/filter-brands/{categoryId}', [HomeController::class, 'filterByCategory']);


        Route::post('/userHiringStore', [HiringController::class, 'storeUser'])->name('userRegister.store');
        Route::post('/userHiringStore', [HiringController::class, 'storeUser'])->name('userHiring.store');
    }
);

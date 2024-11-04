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
    function () {
        // Home Page
        // Route::get('/', [HomeController::class, 'home'])->name('home');

        Route::get('/', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        // Home Category Filter
        Route::get('/filter-brands', [HomeController::class, 'getAllBrands']);
        Route::get('/filter-brands/{categoryId}', [HomeController::class, 'filterByCategory']);

        //About Page
        Route::get('/aboutUs',[HomeController::class, 'aboutUs'])->name('aboutUs');

        //Services Page
        Route::get('/services',[HomeController::class, 'services'])->name('services');

        //Our Works Page
        Route::get('/ourWorks',[HomeController::class, 'ourWorks'])->name('ourWorks');

        //Our Customer Page
        Route::get('/ourCustomer',[HomeController::class, 'ourCustomer'])->name('ourCustomer');

        //Industry Page
        Route::get('/industry',[HomeController::class, 'industry'])->name('industry');

        //Blog Page
        Route::get('/blog',[HomeController::class, 'blog'])->name('blog');

        //Hiring And Training Page
        Route::get('/hiringAndTraining',[HomeController::class, 'hiringAndTraining'])->name('hiringAndTraining');

        //Register Page
        Route::get('/register',[HomeController::class, 'register'])->name('register');

        // Registration Forms
        Route::post('/userHiringStore', [HiringController::class, 'storeUser'])->name('userRegister.store');
        Route::post('/userHiringStore', [HiringController::class, 'storeUser'])->name('userHiring.store');

    }
);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HiringController;
use App\Http\Controllers\Dashboard\UserRegisterController;
use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\HiringPageController;
use App\Http\Controllers\Dashboard\HomeSliderController;
use App\Http\Controllers\Dashboard\JourneySectionImageController;
use App\Http\Controllers\Dashboard\OurWorkController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\PhotographyImageController;
use App\Models\HomeSlider;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/userRegisterStore', [UserRegisterController::class, 'storeUser']);
Route::post('/userHiringStore', [HiringController::class, 'storeUser'])->name('userHiring.store');

// Slider Api
Route::get('/getSlider',[HomeSliderController::class,'getSliderApi']);

// Brand Api
Route::get('/getBrand',[OurWorkController::class,'getBrandApi']);
Route::get('/getBrandDetailsApi',[OurWorkController::class,'getBrandDetailsApi']);
Route::get('/getBrandImagesApi/{id}',[OurWorkController::class,'getBrandImagesApi']);
Route::get('/getBrandApiForService',[OurWorkController::class,'getBrandApiForService']);
Route::get('/getBrandApiForIndustry',[OurWorkController::class,'getBrandApiForIndustry']);

Route::get('/getBrandDetails',[OurWorkController::class,'getBrandDetailsApi']);

// Blog Api
Route::get('/getBlog',[BlogController::class,'getBlogApi']);
Route::get('/getSingleBlog/{id}',[BlogController::class,'getSingleBlogApi']);
Route::get('/blogFilterApi', [BlogController::class, 'blogFilterApi']);

// Journey Image
Route::get('/getImagesSliderApi',[JourneySectionImageController::class,'getImagesSliderApi']);

// Partner Api
Route::get('/getPartnerApi',[PartnerController::class,'getPartnerApi']);

// Services Api
Route::get('/getPhotographyImage',[PhotographyImageController::class,'getPhotographyImage']);

// User Hiring Page Image Api
Route::get('/getUserHiringImage',[HiringPageController::class,'getHiringPageApi']);


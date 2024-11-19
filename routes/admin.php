<?php

use App\Http\Controllers\Dashboard\AboutController;
use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\HiringController;
use App\Http\Controllers\Dashboard\HiringPageController;
use App\Http\Controllers\Dashboard\HomeSectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\HomeSliderController;
use App\Http\Controllers\Dashboard\IndustryController;
use App\Http\Controllers\Dashboard\IndustryServiceController;
use App\Http\Controllers\Dashboard\JourneySectionImageController;
use App\Http\Controllers\Dashboard\OurWorkController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\SystemInfoController;
use App\Http\Controllers\Dashboard\SystemSetupController;
use App\Http\Controllers\Dashboard\UserRegisterController;
use App\Http\Controllers\PhotographyImageController;
use App\Http\Controllers\UserController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () { //...

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

        Route::prefix('industry')->group(function () {
            Route::get('/index', [IndustryServiceController::class, 'index'])->name('industry.index');
            Route::get('/dataTable', [IndustryServiceController::class, 'getIndustryService'])->name('industry.dataTable');
            Route::get('/addIndustryService', [IndustryServiceController::class, 'addIndustryService'])->name('industry.addIndustry');
            Route::post('/storeIndustryService', [IndustryServiceController::class, 'storeIndustryService'])->name('industry.store');
            Route::get('/editIndustryService/{id}', [IndustryServiceController::class, 'editIndustryService'])->name('industry.edit');
            Route::post('/updateIndustryService/{id}', [IndustryServiceController::class, 'updateIndustryService'])->name('industry.update');
            Route::get('/updateStatus/{industry}', [IndustryServiceController::class, 'updateStatus'])->name('industry.status');
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

        Route::prefix('about')->group(function () {
            Route::get('/editAbout/edit', [AboutController::class, 'editAbout'])->name('editAbout');
            Route::post('/updateAbout/update', [AboutController::class, 'updateAbout'])->name('updateAbout');
        });

        Route::prefix('service')->group(function () {
            Route::get('/editService/edit', [ServiceController::class, 'editService'])->name('editService');
            Route::post('/updateService/update', [ServiceController::class, 'updateService'])->name('updateService');
        });

        Route::prefix('industry')->group(function () {
            Route::get('/editIndustry/edit', [IndustryController::class, 'editIndustry'])->name('editIndustry');
            Route::post('/updateIndustry/update', [IndustryController::class, 'updateIndustry'])->name('updateIndustry');
        });

        Route::prefix('homeSection')->group(function () {
            Route::get('/editHomeSection/edit', [HomeSectionController::class, 'editHomeSection'])->name('editHomeSection');
            Route::post('/updateHomeSection/update', [HomeSectionController::class, 'updateHomeSection'])->name('updateHomeSection');

            Route::get('/journeyImage', [JourneySectionImageController::class, 'index'])->name('journeyImage.index');
            Route::get('/dataTable', [JourneySectionImageController::class, 'getImages'])->name('journeyImage.dataTable');
            Route::post('/storeJourneyImage', [JourneySectionImageController::class, 'storeImage'])->name('journeyImage.store');
            Route::post('/updateJourneyImage/{id}', [JourneySectionImageController::class, 'updateImage'])->name('journeyImage.update');
            Route::get('/updateStatus/{journeySectionImage}', [JourneySectionImageController::class, 'updateStatus'])->name('journeyImage.status');
            Route::get('/deleteImage/{id}', [JourneySectionImageController::class, 'deleteImage'])->name('journeyImage.delete');
        });

        Route::prefix('hiringPage')->group(function () {
            Route::get('/hiringPage/edit', [HiringPageController::class, 'editHiringPage'])->name('editHiringPage');
            Route::post('/hiringPage/update', [HiringPageController::class, 'updateHiringPage'])->name('updateHiringPage');
        });

        Route::prefix('brand')->group(function () {
            Route::get('/index', [OurWorkController::class, 'index'])->name('brand.index');
            Route::get('/dataTable', [OurWorkController::class, 'getBrand'])->name('brand.dataTable');
            Route::get('/addBrand', [OurWorkController::class, 'addBrand'])->name('brand.addBrand');
            Route::post('/storeBrand', [OurWorkController::class, 'storeBrand'])->name('brand.store');
            Route::get('/editBrand/{id}', [OurWorkController::class, 'editBrand'])->name('brand.edit');
            Route::post('/updateBrand/{id}', [OurWorkController::class, 'updateBrand'])->name('brand.update');
            Route::get('/updateStatus/{ourWork}', [OurWorkController::class, 'updateStatus'])->name('brand.status');
            Route::get('/brandDetails/edit/{id}', [OurWorkController::class, 'brandDetails'])->name('brandDetails');
            Route::post('/brandDetails/update/{id}', [OurWorkController::class, 'brandDetailsUpdate'])->name('brandDetailsUpdate');
            Route::get('/deleteBrand/{id}', [OurWorkController::class, 'deleteBrand'])->name('brand.delete');
        });

        Route::prefix('users')->group(function () {
            Route::get('/userRegister', [UserRegisterController::class, 'index'])->name('userRegister.index');
            Route::get('/userRegisterDataTable', [UserRegisterController::class, 'dataTable'])->name('userRegister.dataTable');

            Route::get('/userHiring', [HiringController::class, 'index'])->name('userHiring.index');
            Route::get('/userHiringDataTable', [HiringController::class, 'dataTable'])->name('userHiring.dataTable');

            Route::get('/editHiringPage', [HiringPageController::class, 'editHiringPage'])->name('userHiring.editHiringPage');
            Route::post('/updateHiringPage', [HiringPageController::class, 'updateHiringPage'])->name('userHiring.updateHiringPage');
        });

        Route::prefix('blog')->group(function () {
            Route::get('/index', [BlogController::class, 'index'])->name('blog.index');
            Route::get('/dataTable', [BlogController::class, 'getBlog'])->name('blog.dataTable');
            Route::get('/addBlog', [BlogController::class, 'addBlog'])->name('blog.addBlog');
            Route::post('/storeBlog', [BlogController::class, 'storeBlog'])->name('blog.store');
            Route::get('/editBlog/{id}', [BlogController::class, 'editBlog'])->name('blog.edit');
            Route::post('/updateBlog/{id}', [BlogController::class, 'updateBlog'])->name('blog.update');
            Route::get('/updateStatus/{blog}', [BlogController::class, 'updateStatus'])->name('blog.status');
            Route::get('/deleteBlog/{id}', [BlogController::class, 'deleteBlog'])->name('blog.delete');
            Route::get('/filter', [BlogController::class, 'filter'])->name('blog.filter');


            Route::get('/blogTest/{id}', [BlogController::class, 'blogTest'])->name('blog.blogTest');

            // Soft Delete Route
            Route::get('/softDeleteBlog/{id}', [BlogController::class, 'softDeleteBlog'])->name('blog.softDeleteBlog');
            Route::get('/blogTrash', [BlogController::class, 'blogTrash'])->name('blog.blogTrash');
            Route::get('/getBlogForTrash', [BlogController::class, 'getBlogForTrash'])->name('blog.getBlogForTrash');
            Route::get('/restoreBlog/{id}', [BlogController::class, 'restoreBlog'])->name('blog.restoreBlog');

        });

        /////route User
        Route::prefix('agent')->middleware('ensureSessionIsActive')->group(function () {
            Route::get('/index/{role}', [UserController::class, 'index'])->name('user.index');
            Route::get('/datatable/{id}', [UserController::class, 'datatable'])->name('user.datatable');
            Route::get('/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/store', [UserController::class, 'store'])->name('user.store');
            Route::post('/update', [UserController::class, 'update'])->name('user.update');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
            Route::get('/delete/{user}', [UserController::class, 'delete'])->name('user.delete');
        });

        Route::prefix('photography')->group(function () {
            Route::get('/index', [PhotographyImageController::class, 'index'])->name('photography.index');
            Route::get('/dataTable', [PhotographyImageController::class, 'getPhotography'])->name('photography.dataTable');
            Route::get('/addPhotography', [PhotographyImageController::class, 'addPhotography'])->name('photography.addPhotography');
            Route::post('/storePhotography', [PhotographyImageController::class, 'storePhotography'])->name('photography.store');
            Route::get('/editPhotography/{id}', [PhotographyImageController::class, 'editPhotography'])->name('photography.edit');
            Route::post('/updatePhotography/{id}', [PhotographyImageController::class, 'updatePhotography'])->name('photography.update');
            Route::get('/deletePhotography/{id}', [PhotographyImageController::class, 'deletePhotography'])->name('photography.delete');
            Route::get('/updateStatus/{photographyImage}', [PhotographyImageController::class, 'updateStatus'])->name('photography.status');
        });
    }
);

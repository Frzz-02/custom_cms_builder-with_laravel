<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CompleteCountController;
use App\Http\Controllers\Backend\SocialLinkController;
use App\Http\Controllers\Backend\FooterController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SectionHeroController;
use App\Http\Controllers\Backend\SectionAboutController;
use App\Http\Controllers\Backend\HeaderController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\FrontendController;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/products/{slug}', [FrontendController::class, 'showProduct'])->name('products.detail');
Route::get('/{slug}', [FrontendController::class, 'show'])->name('pages.show');







Route::group(['prefix' => 'cihuy'], function () {

    // Authentication Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
});

// Backend Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::prefix('bagoosh')->name('backend.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('pages/initiate', [App\Http\Controllers\Backend\PageController::class, 'initiate'])->name('pages.initiate');
        Route::resource('pages', App\Http\Controllers\Backend\PageController::class);
        
                
        // Brand Routes
        Route::resource('brands', BrandController::class);
        
        // Complete Count Routes
        Route::resource('complete-count', CompleteCountController::class);
        
        // Social Links Routes
        Route::resource('social-links', SocialLinkController::class);
        
        // Footer Routes
        Route::resource('footer', FooterController::class);
        
        // User Routes
        Route::resource('users', UserController::class);
        
        // Section Hero Routes
        Route::post('section-hero/store-ajax', [SectionHeroController::class, 'storeAjax'])->name('section-hero.store-ajax');
        Route::get('section-hero/show-ajax/{id}', [SectionHeroController::class, 'showAjax'])->name('section-hero.show-ajax');
        Route::delete('section-hero/delete-ajax/{id}', [SectionHeroController::class, 'deleteAjax'])->name('section-hero.delete-ajax');
        Route::resource('section-hero', SectionHeroController::class);
        
        // Section About Routes
        Route::resource('section-about', SectionAboutController::class);
        
        // Header/Navbar Routes
        Route::resource('header', HeaderController::class);
        
        // Product Category Routes
        Route::resource('product-categories', ProductCategoryController::class);
        
        // Product Routes
        Route::resource('products', ProductController::class);
    });
});

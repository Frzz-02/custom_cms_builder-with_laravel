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
use App\Http\Controllers\Backend\PageShortcodeController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\WhatsAppButtonController;
use App\Http\Controllers\Backend\SectionTestimonialController;
use App\Http\Controllers\Backend\SectionServiceController;
use App\Http\Controllers\Backend\SectionNewsletterController;
use App\Http\Controllers\Backend\NewsletterController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ThemeEditorController;
use App\Http\Controllers\Backend\MediaController;
use App\Http\Controllers\Frontend\FrontendController;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/products/{slug}', [FrontendController::class, 'showProduct'])->name('products.detail');
Route::get('/{slug}', [FrontendController::class, 'show'])->name('pages.show');


Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [FrontendController::class, 'showBlog'])->name('blog.show');





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
        
        
        
        // Testimonials Routes
        Route::get('testimonials/list', [PageShortcodeController::class, 'getTestimonialsList'])->name('testimonials.list');
        
        // Services Routes
        Route::get('services/list', [PageShortcodeController::class, 'getServicesList'])->name('services.list');
        
        // Newsletters Routes
        Route::get('section-newsletters/list', [PageShortcodeController::class, 'getSectionNewslettersList'])->name('newsletters.list');
        
        // Contacts Routes
        Route::get('contacts/list', [PageShortcodeController::class, 'getContactsList'])->name('contacts.list');
        
        // Page Shortcode Routes
        Route::post('page-shortcode/store', [PageShortcodeController::class, 'store'])->name('page-shortcode.store');
        Route::get('page-shortcode/show/{id}', [PageShortcodeController::class, 'show'])->name('page-shortcode.show');
        Route::put('page-shortcode/update/{id}', [PageShortcodeController::class, 'update'])->name('page-shortcode.update');
        Route::delete('page-shortcode/delete/{id}', [PageShortcodeController::class, 'destroy'])->name('page-shortcode.destroy');
        
        // Header/Navbar Routes
        Route::resource('header', HeaderController::class);
        
        // Product Category Routes
        Route::get('product-categories/list', [ProductCategoryController::class, 'getList'])->name('product-categories.list');
        Route::resource('product-categories', ProductCategoryController::class);
        
        // Product Routes
        Route::resource('products', ProductController::class);
        
        // Blog Category Routes
        Route::resource('blog-categories', BlogCategoryController::class);
        
        // Blog Routes
        Route::resource('blogs', BlogController::class);
        
        // Contact Routes
        Route::resource('contacts', ContactController::class);
        
        // WhatsApp Button Routes
        Route::get('whatsapp-button', [WhatsAppButtonController::class, 'index'])->name('whatsapp-button.index');
        Route::post('whatsapp-button', [WhatsAppButtonController::class, 'store'])->name('whatsapp-button.store');
        
        // Testimonials Routes
        Route::resource('testimonials', SectionTestimonialController::class);
        
        // Services Routes
        Route::get('section-services/list', [SectionServiceController::class, 'getList'])->name('section-services.list');
        Route::resource('services', SectionServiceController::class);
        
        // Newsletter Settings Routes
        Route::get('newsletter/settings', [SectionNewsletterController::class, 'index'])->name('newsletter.settings');
        Route::post('newsletter/settings', [SectionNewsletterController::class, 'store'])->name('newsletter.settings.store');
        
        // Newsletter Subscribers Routes
        Route::get('newsletter/subscribers', [NewsletterController::class, 'index'])->name('newsletter.subscribers');
        Route::delete('newsletter/subscribers/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletter.subscribers.destroy');
        
        // Media Routes
        Route::get('media/list', [MediaController::class, 'getList'])->name('media.list');
        Route::resource('media', MediaController::class)->only(['index', 'store', 'destroy']);
        
        // Theme Editor Routes (Only for Superadmin)
        Route::get('theme-editor', [ThemeEditorController::class, 'index'])->name('theme-editor.index');
        Route::get('theme-editor/edit', [ThemeEditorController::class, 'edit'])->name('theme-editor.edit');
        Route::post('theme-editor/update', [ThemeEditorController::class, 'update'])->name('theme-editor.update');
        Route::get('theme-editor/files', [ThemeEditorController::class, 'getFiles'])->name('theme-editor.files');
        
        // Settings Routes
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('settings/remove-image', [SettingController::class, 'removeImage'])->name('settings.remove-image');
    });
});

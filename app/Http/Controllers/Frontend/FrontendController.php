<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Footer;
use App\Models\Media;
use App\Models\SectionHero;
use App\Models\SectionBrand;
use App\Models\SectionAbout;
use App\Models\Navbar;
use App\Models\Page;
use App\Models\PageShortcode;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\WhatsappButton;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $footer = Footer::where('is_active', true)->first();
        $heroPanels = SectionHero::where('is_active', true)
                                ->orderBy('panel_order')
                                ->get();
        $brands = SectionBrand::where('status', 'active')->get();
        
        
        // Get navbar items (top navigation)
        $navbarItems = Navbar::where('is_active', true)
                            ->where('show_in_navbar', true)
                            ->whereNull('parent_id')
                            ->orderBy('menu_order')
                            ->with('children')
                            ->get();
        
        // Get sidebar items
        $sidebarItems = Navbar::where('is_active', true)
                             ->where('show_in_sidebar', true)
                             ->whereNull('parent_id')
                             ->orderBy('menu_order')
                             ->with('children')
                             ->get();
        
        return view('frontend.pages.show', compact('footer', 'heroPanels', 'brands', 'about', 'navbarItems', 'sidebarItems'));
    }




    public function show($slug = null)
    {   
        
        try {
            // Get the page by slug and check for 'active' status
            $page = Page::where('slug', $slug)->where('status', 'published')->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If no page is found, return a 404 error
            abort(404);
        }

        $footer = Footer::first();
        $settings = Setting::first();
        $navbar = Navbar::first();
        $media = Media::latest()->get();
        $whatsappButton = WhatsappButton::first();
        $menus = Page::where('status', 'active')->get();
        $socialLinks = SocialLink::where('status', 'active')->latest()->get();

        $shortcodes = PageShortcode::where('pages_id', $page->id)
            ->orderBy('sort_id', 'asc')
            ->get();

        $blogLimit =
            PageShortcode::where('pages_id', $page->id)
                ->where('type', 'latestnews')
                ->orderBy('sort_id', 'asc')
                ->value('blog_limit') ?? 0;

        $blogs = Blog::with([
            'category' => function ($query) {
                $query->where('status', 'active');
            },
        ])
            ->where('status', 'active')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest()
            ->take($blogLimit)
            ->get();

        $blogss = Blog::where('status', 'active')->latest()->paginate(2);
        $recent_blogs = Blog::where('status', 'active')->latest()->take(5)->get();
        $categories = BlogCategory::where('status', 'active')
            ->withCount([
                'blogs' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->get();

        $authors = $blogs->pluck('author')->unique();
        $users = User::whereIn('name', $authors)->get();


        $products = Product::where('status', 'active')
            ->latest()
            ->paginate(8, ['*'], 'product_page');

        $layout = 'frontend.layouts.pages.master-default';

        if ($page->template == 'homepage') {
            $layout = 'frontend.layouts.pages.master-homepage';
        } elseif ($page->template == 'page detail') {
            $layout = 'frontend.layouts.pages.master-pagedetail';
        } elseif ($page->template == 'sidebar') {
            $layout = 'frontend.layouts.pages.master-sidebar';
        } elseif ($page->template == 'default') {
            $layout = 'frontend.layouts.pages.master-default';
        } elseif ($page->template == 'coming soon') {
            $layout = 'frontend.layouts.pages.master-comingsoon';
        }

        return view('frontend.pages.showPage', compact('products', 'recent_blogs', 'categories', 'blogss', 'users', 'socialLinks', 'blogs', 'page', 'settings', 'footer', 'navbar', 'whatsappButton', 'media', 'shortcodes', 'layout'));
    }


    
    
    
    public function showProduct($slug)
    {
        $footer = Footer::where('is_active', true)->first();

        
         // Get navbar items (top navigation)
        $navbarItems = Navbar::where('is_active', true)
                            ->where('show_in_navbar', true)
                            ->whereNull('parent_id')
                            ->orderBy('menu_order')
                            ->with('children')
                            ->get();
        
        
        // Get sidebar items
        $sidebarItems = Navbar::where('is_active', true)
                             ->where('show_in_sidebar', true)
                             ->whereNull('parent_id')
                             ->orderBy('menu_order')
                             ->with('children')
                             ->get();
        
        
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get related products from same category
        $relatedProducts = Product::where('product_categories_id', $product->product_categories_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        // WhatsApp settings - bisa diganti dengan setting dari database
        $whatsappNumber = '6281234567890'; // Ganti dengan nomor WhatsApp bisnis
        $message = "Halo, saya tertarik dengan produk *{$product->title}* (Kode: {$product->products_code})\n\n";
        $message .= "Link: " . url('/products/' . $product->slug);
        
        $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($message);

        return view('frontend.pages.product.detail', compact('product', 'relatedProducts', 'whatsappUrl', 'footer', 'navbarItems', 'sidebarItems'));
    }
}

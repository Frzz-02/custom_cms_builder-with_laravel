<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Footer;
use App\Models\Media;
use App\Models\Navbar;
use App\Models\Page;
use App\Models\PageShortcode;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\WhatsappButton;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function index()
    {   
        
        try {
            // Get the page by slug and check for 'active' status
            $page = Page::whereNull('slug')->where('status', 'published')->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If no page is found, return a 404 error
            abort(404);
        }

        $footer = Footer::first();
        $settings = Setting::first();
        $navbar = Navbar::first();
        $navbarItems = Navbar::where('is_active', true)
            ->where('show_in_navbar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
        $sidebarItems = Navbar::where('is_active', true)
            ->where('show_in_sidebar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
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
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest()
            ->take($blogLimit)
            ->get();

        $blogss = Blog::where('status', 'published')->latest()->paginate($blogLimit, ['*'], 'blog_page');
        $recent_blogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::where('status', 'active')
            ->withCount([
                'blogs' => function ($query) {
                    $query->where('status', 'published');
                },
            ])
            ->get();

        $authors = $blogs->pluck('author')->unique();
        $users = User::whereIn('name', $authors)->get();


        $products = Product::with(['category:id,name,slug'])
            ->where('status', 'active')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest()->get();
        // dd($products);

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

        $isBlogPage = false;
        
        return view('frontend.pages.showPage', compact('products', 'recent_blogs', 'categories', 'blogss', 'users', 'socialLinks', 'blogs', 'page', 'settings', 'footer', 'navbar', 'navbarItems', 'sidebarItems', 'whatsappButton', 'media', 'shortcodes', 'layout', 'isBlogPage'));
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
        $navbarItems = Navbar::where('is_active', true)
            ->where('show_in_navbar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
        $sidebarItems = Navbar::where('is_active', true)
            ->where('show_in_sidebar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
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
            ->where('status', 'published')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest()
            ->take($blogLimit)
            ->get();

        $blogss = Blog::where('status', 'published')->latest()->paginate($blogLimit, ['*'], 'blog_page');
        $recent_blogs = Blog::where('status', 'published')->latest()->take(5)->get();
        $categories = BlogCategory::where('status', 'active')
            ->withCount([
                'blogs' => function ($query) {
                    $query->where('status', 'published');
                },
            ])
            ->get();

        $authors = $blogs->pluck('author')->unique();
        $users = User::whereIn('name', $authors)->get();


        $products = Product::with(['category:id,name,slug'])
            ->where('status', 'active')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest()->get();
            // ->paginate(8, ['*'], 'product_page');
            
        
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

        $isBlogPage = false;

        return view('frontend.pages.showPage', compact('products', 'recent_blogs', 'categories', 'blogss', 'users', 'socialLinks', 'blogs', 'page', 'settings', 'footer', 'navbar', 'navbarItems', 'sidebarItems', 'whatsappButton', 'media', 'shortcodes', 'layout', 'isBlogPage'));
    }


    
    
    
    public function showProduct(Request $request, $slug)
    {
        $page = null;
        $pageContextToken = $request->query('ctx');

        if (!empty($pageContextToken)) {
            try {
                $pageId = decrypt($pageContextToken);
                if (is_numeric($pageId)) {
                    $page = Page::find((int) $pageId);
                }
            } catch (\Throwable $exception) {
                $page = null;
            }
        }

        if (!$page) {
            $page = Page::whereNull('slug')->where('status', 'published')->first();
        }

        $footer = Footer::where('is_active', true)->first();
        $settings = Setting::first();
        
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

        // dd($page);
        return view('frontend.pages.product.detail', compact('product', 'relatedProducts', 'whatsappUrl', 'footer', 'navbarItems', 'sidebarItems', 'settings', 'page'));
    }





    public function blog()
    {
        $page = Page::where('slug', 'blog')->where('status', 'published')->first();

        if (! $page) {
            $page = Page::whereNull('slug')->where('status', 'published')->firstOrFail();
        }

        $footer = Footer::first();
        $settings = Setting::first();
        $navbar = Navbar::first();
        $navbarItems = Navbar::where('is_active', true)
            ->where('show_in_navbar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
        $sidebarItems = Navbar::where('is_active', true)
            ->where('show_in_sidebar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
        $media = Media::latest()->get();
        $whatsappButton = WhatsappButton::first();

        $blogss = Blog::with('category')
            ->published()
            ->latest()
            ->paginate(9);

        $recent_blogs = Blog::published()->latest()->take(5)->get();

        $categories = BlogCategory::where('status', 'active')
            ->withCount([
                'blogs' => function ($query) {
                    $query->where('status', 'published');
                },
            ])
            ->get();

        $blogDetail = false;
        $isBlogPage = true;

        return view('frontend.pages.blogs.index', compact(
            'page',
            'settings',
            'footer',
            'navbar',
            'navbarItems',
            'sidebarItems',
            'whatsappButton',
            'media',
            'blogss',
            'recent_blogs',
            'categories',
            'blogDetail',
            'isBlogPage'
        ));
    }





    public function showBlog($slug)
    {
        $blog = Blog::with('category')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $page = Page::where('slug', 'blog')->where('status', 'published')->first();

        if (! $page) {
            $page = Page::whereNull('slug')->where('status', 'published')->firstOrFail();
        }

        $page->meta_title = $blog->meta_title ?: $blog->title;
        $page->meta_description = $blog->meta_description ?: Str::limit(strip_tags((string) $blog->content), 160);
        $page->meta_keywords = $blog->meta_keywords ?: $page->meta_keywords;
        $page->slug = 'blog/' . $blog->slug;

        $footer = Footer::first();
        $settings = Setting::first();
        $navbar = Navbar::first();
        $navbarItems = Navbar::where('is_active', true)
            ->where('show_in_navbar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
        $sidebarItems = Navbar::where('is_active', true)
            ->where('show_in_sidebar', true)
            ->whereNull('parent_id')
            ->orderBy('menu_order')
            ->with('children')
            ->get();
        $media = Media::latest()->get();
        $whatsappButton = WhatsappButton::first();

        $categories = BlogCategory::where('status', 'active')
            ->withCount([
                'blogs' => function ($query) {
                    $query->where('status', 'published');
                },
            ])
            ->get();

        $recent_blogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(5)
            ->get();

        $blogss = Blog::published()->latest()->paginate(9);

        $readingTime = max(1, (int) ceil(str_word_count(strip_tags((string) $blog->content)) / 200));
        $blogDetail = true;
        $isBlogPage = true;

        return view('frontend.pages.blogs.detail', compact(
            'blog',
            'page',
            'settings',
            'footer',
            'navbar',
            'navbarItems',
            'sidebarItems',
            'whatsappButton',
            'media',
            'categories',
            'recent_blogs',
            'blogss',
            'readingTime',
            'blogDetail',
            'isBlogPage'
        ));
    }



    public function showProductCategory(ProductCategory $productCategory)
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
        
        
        $products = Product::with('category')
            ->where('product_categories_id', $productCategory->id)
            ->where('status', 'active')
            ->latest()
            ->paginate(8);

        return view('frontend.pages.product.category', compact('products', 'productCategory', 'footer', 'navbarItems', 'sidebarItems'));
    }
    
    
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\SectionHero;
use App\Models\SectionBrand;
use App\Models\SectionAbout;
use App\Models\Navbar;
use App\Models\Page;
use App\Models\PageShortcode;
use App\Models\Product;
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
        $footer = Footer::where('is_active', true)->first();
        
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
                     
        
        $page = Page::where('status', 'active');
        
        if ($slug == null) {
            $page->whereNull('slug');
        }else{
            $page->where('slug', $slug);
        }

        $page = $page->firstOrFail();
                             
        
        $shortcodes = PageShortcode::with(['faqCategory'])
            ->where('pages_id', $page->id)
            ->orderBy('sort_id', 'asc')
            ->get();
        
        
        dd([$footer, $brands, $navbarItems, $sidebarItems, $slug, $page, $shortcodes]);
        return view('frontend.pages.showPage', compact('footer', 'heroPanels', 'brands', 'about', 'navbarItems', 'sidebarItems', 'slug'));
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

@php
    $selectedCategoryData = $selectedCategory ?? null;
    $metaTitle = $selectedCategoryData?->meta_title ?? $selectedCategoryData?->name ?? 'Kategori Produk';
    $metaDescription = $selectedCategoryData?->meta_description
        ?? \Illuminate\Support\Str::limit(strip_tags((string) ($selectedCategoryData?->description ?? 'Daftar produk berdasarkan kategori.')), 160);
    $metaKeywords = $selectedCategoryData?->meta_keywords
        ?? ($selectedCategoryData ? 'produk, kategori, ' . $selectedCategoryData->name : 'produk, kategori');

    $visibleTabs = $categories->take(5);
    $hiddenTabs = $categories->slice(5);

    $resolveProductImage = function (?string $image): ?string {
        if (blank($image)) {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://', '//'])) {
            return $image;
        }

        $path = parse_url($image, PHP_URL_PATH) ?: $image;
        $path = ltrim($path, '/');

        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        if (\Illuminate\Support\Str::startsWith($path, 'uploads/')) {
            return asset('storage/' . $path);
        }

        if (!str_contains($path, '/')) {
            return asset('storage/uploads/' . $path);
        }

        return asset('storage/' . $path);
    };
@endphp

@extends('frontend.layouts.pages.master-pagedetail')
@section('page_title', $selectedCategoryData?->name ?? ($settings->site_title ?? 'MitraCom'))
@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)

@section('content')
<section class="w-full px-6 md:px-12 lg:px-16 pt-14 pb-16">
    <div class="mb-10">
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-2">Koleksi Kami</p>
        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-3">
            {{ $selectedCategoryData?->name ?? 'Semua Produk' }}
        </h1>
        <p class="text-gray-500 text-base md:text-lg max-w-2xl">
            {{ $selectedCategoryData?->description ?: 'Jelajahi semua produk aktif berdasarkan kategori.' }}
        </p>
    </div>

    <div x-data="{ open: false }" class="flex flex-wrap items-center gap-3 mb-10">
        <a href="{{ route('product.category') }}"
           class="px-5 py-2 rounded-full text-sm font-semibold transition-colors {{ $selectedCategoryData ? 'border border-gray-200 text-gray-600 hover:border-gray-400' : 'bg-gray-900 text-white' }}">
            Semua
        </a>

        @foreach($visibleTabs as $categoryTab)
            <a href="{{ route('product.category', $categoryTab->slug) }}"
               class="px-5 py-2 rounded-full text-sm font-medium transition-colors {{ $selectedCategoryData && $selectedCategoryData->id === $categoryTab->id ? 'bg-gray-900 text-white' : 'border border-gray-200 text-gray-600 hover:border-gray-400' }}">
                {{ $categoryTab->name }}
            </a>
        @endforeach

        @if($hiddenTabs->isNotEmpty())
            <div class="relative">
                <button type="button"
                        @click="open = !open"
                        class="px-4 py-2 rounded-full border border-gray-200 text-gray-700 text-sm font-semibold hover:border-gray-400 transition-colors">
                    ...
                </button>

                <div x-show="open"
                     x-cloak
                     @click.outside="open = false"
                     class="absolute z-20 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-lg p-2">
                    @foreach($hiddenTabs as $categoryTab)
                        <a href="{{ route('product.category', $categoryTab->slug) }}"
                           class="block px-3 py-2 rounded-lg text-sm {{ $selectedCategoryData && $selectedCategoryData->id === $categoryTab->id ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            {{ $categoryTab->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                @php
                    $productImage = $resolveProductImage($product->image);
                    $showPrice = (bool) $product->show_price;
                @endphp
                <a href="{{ route('products.detail', $product->slug) }}"
                   class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-shadow group">
                    <div class="relative h-52 overflow-hidden bg-gray-100">
                        @if($productImage)
                            <img src="{{ $productImage }}"
                                 alt="{{ $product->image_title ?: $product->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No Image</div>
                        @endif

                        @if($product->is_featured === 'yes')
                            <span class="absolute top-3 left-3 bg-amber-400 text-white text-xs font-bold px-3 py-1 rounded-full">
                                Featured
                            </span>
                        @endif
                    </div>

                    <div class="p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                        <h3 class="text-sm font-bold text-gray-900 mb-2 leading-snug line-clamp-2">{{ $product->title }}</h3>

                        @if($product->overview)
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $product->overview }}</p>
                        @endif

                        <div class="flex items-center justify-between gap-2">
                            @if($showPrice)
                                <div class="flex flex-col">
                                    @if(!is_null($product->sale_price) && !is_null($product->price) && $product->sale_price < $product->price)
                                        <span class="text-base font-extrabold text-gray-900">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @elseif(!is_null($product->price))
                                        <span class="text-base font-extrabold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm font-semibold text-gray-500">Harga belum tersedia</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-sm font-semibold text-gray-500">Hubungi kami</span>
                            @endif

                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok habis' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($products->hasPages())
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    @else
        <div class="rounded-2xl border border-gray-200 bg-white p-10 text-center">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Produk belum tersedia</h3>
            <p class="text-gray-500">Belum ada produk aktif untuk kategori ini.</p>
        </div>
    @endif
</section>
@endsection

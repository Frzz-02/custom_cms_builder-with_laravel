@extends('frontend.layouts.pages.master-homepage')
@section('title', $product->meta_title ?? $product->title)

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="/" class="text-slate-600 hover:text-indigo-600 transition-colors">
                    <i class="fas fa-home"></i> Home
                </a>
                <i class="fas fa-chevron-right text-slate-400 text-xs"></i>
                <a href="/products" class="text-slate-600 hover:text-indigo-600 transition-colors">Products</a>
                <i class="fas fa-chevron-right text-slate-400 text-xs"></i>
                <span class="text-slate-900 font-medium">{{ Str::limit($product->title, 30) }}</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <!-- Product Detail Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Left: Product Image -->
                <div class="relative bg-gradient-to-br from-slate-50 to-slate-100 p-6 lg:p-10">
                    <div class="sticky top-24">
                        <!-- Main Image -->
                        <div class="aspect-square rounded-2xl overflow-hidden bg-white shadow-lg mb-4 group">
                            @if($product->image)
                                <img src="{{ $product->image }}" 
                                     alt="{{ $product->image_title ?? $product->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-box-open text-slate-300 text-7xl mb-3"></i>
                                        <p class="text-slate-400 text-sm">No Image</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-600 rounded-full text-sm font-semibold shadow-md border border-indigo-100">
                                <i class="fas fa-tag"></i>
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                            @if($product->is_featured === 'yes')
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-400 to-yellow-400 text-white rounded-full text-sm font-semibold shadow-md">
                                    <i class="fas fa-star"></i>
                                    Featured
                                </span>
                            @endif
                            @if($product->stock > 0)
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold shadow-md">
                                    <i class="fas fa-check-circle"></i>
                                    In Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: Product Info -->
                <div class="p-6 lg:p-10 flex flex-col">
                    <!-- Product Code -->
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-mono">
                            <i class="fas fa-barcode"></i>
                            {{ $product->products_code }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-4 leading-tight">
                        {{ $product->title }}
                    </h1>

                    <!-- Stock & Rating -->
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-200">
                        @if($product->stock > 0)
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-green-600 font-semibold text-sm">
                                    {{ $product->stock }} units available
                                </span>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                <span class="text-red-600 font-semibold text-sm">Out of Stock</span>
                            </div>
                        @endif
                    </div>

                    <!-- Price Section -->
                    <div class="mb-8">
                        <p class="text-sm text-slate-500 mb-2 uppercase tracking-wider font-semibold">Price</p>
                        <div class="flex items-end gap-4 mb-3">
                            @if($product->sale_price)
                                <div class="flex flex-col">
                                    <span class="text-5xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        Rp {{ number_format($product->sale_price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-lg text-slate-400 line-through mt-1">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 text-white rounded-lg text-sm font-bold mb-2">
                                    <i class="fas fa-fire-alt"></i>
                                    -{{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%
                                </div>
                            @else
                                <span class="text-5xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        @if($product->sale_price)
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-xl">
                                <i class="fas fa-piggy-bank text-green-600"></i>
                                <span class="text-green-700 font-semibold text-sm">
                                    Save Rp {{ number_format($product->price - $product->sale_price, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Overview -->
                    @if($product->overview)
                        <div class="mb-8 p-5 bg-slate-50 rounded-2xl border border-slate-200">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-slate-900 mb-3 uppercase tracking-wider">
                                <i class="fas fa-info-circle text-indigo-600"></i>
                                Quick Overview
                            </h3>
                            <p class="text-slate-700 leading-relaxed">{{ $product->overview }}</p>
                        </div>
                    @endif

                    <!-- WhatsApp CTA -->
                    <div class="mt-auto space-y-4">
                        <a href="{{ $whatsappUrl }}" 
                           target="_blank"
                           class="group relative w-full flex items-center justify-center gap-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-5 px-8 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl shadow-lg overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <i class="fab fa-whatsapp text-3xl relative z-10"></i>
                            <div class="relative z-10 text-left">
                                <div class="text-sm opacity-90">Order Now via</div>
                                <div class="text-lg font-bold">WhatsApp</div>
                            </div>
                            <i class="fas fa-arrow-right text-xl ml-auto relative z-10 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                        
                        <div class="flex items-center justify-center gap-6 text-sm text-slate-500">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-shield-check text-green-500"></i>
                                Secure Payment
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-truck text-blue-500"></i>
                                Fast Delivery
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        @if($product->content)
            <div class="mt-8 bg-white rounded-3xl shadow-xl p-6 lg:p-10 border border-slate-200">
                <h2 class="flex items-center gap-3 text-2xl lg:text-3xl font-bold text-slate-900 mb-6">
                    <div class="w-1 h-8 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                    Product Description
                </h2>
                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">
                    {!! nl2br(e($product->content)) !!}
                </div>
            </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="flex items-center gap-3 text-2xl lg:text-3xl font-bold text-slate-900">
                        <div class="w-1 h-8 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                        You May Also Like
                    </h2>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.detail', $related->slug) }}" 
                           class="group bg-white rounded-2xl shadow-md hover:shadow-2xl overflow-hidden border border-slate-200 transition-all duration-300 transform hover:-translate-y-2">
                            <!-- Image -->
                            <div class="aspect-square bg-slate-100 overflow-hidden relative">
                                @if($related->image)
                                    <img src="{{ $related->image }}" 
                                         alt="{{ $related->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-box-open text-slate-300 text-4xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Featured Badge -->
                                @if($related->is_featured === 'yes')
                                    <div class="absolute top-2 right-2 bg-amber-400 text-white px-2 py-1 rounded-lg text-xs font-bold shadow-lg">
                                        <i class="fas fa-star"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-slate-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors min-h-[2.5rem]">
                                    {{ $related->title }}
                                </h3>
                                
                                <!-- Price -->
                                <div class="flex flex-col gap-1">
                                    @if($related->sale_price)
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-bold text-indigo-600">
                                                Rp {{ number_format($related->sale_price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs px-1.5 py-0.5 bg-red-100 text-red-600 rounded font-semibold">
                                                -{{ number_format((($related->price - $related->sale_price) / $related->price) * 100, 0) }}%
                                            </span>
                                        </div>
                                        <span class="text-xs text-slate-400 line-through">
                                            Rp {{ number_format($related->price, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-lg font-bold text-indigo-600">
                                            Rp {{ number_format($related->price ?? 0, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .prose {
            line-height: 1.75;
        }
        
        .prose p {
            margin-bottom: 1.25rem;
        }
    </style>
@endsection
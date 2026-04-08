
@if ($shortcode->type == 'recent-product')
    

    @php
    
        if (!isset($products) || !($products instanceof \Illuminate\Support\Collection)) {
            $products = collect([
                (object) [
                    'title' => 'Alat Tulis Kantor',
                    'overview' => 'Perlengkapan ATK untuk kebutuhan operasional kantor dan instansi.',
                    'image' => 'images/hero/alattuliskantor.jpg',
                    'price' => 5000,
                    'sale_price' => null,
                    'slug' => 'alat-tulis-kantor',
                ],
                (object) [
                    'title' => 'Alat Kebersihan',
                    'overview' => 'Produk kebersihan profesional untuk kantor, sekolah, dan fasilitas publik.',
                    'image' => 'images/hero/alatkebersihan.jpg',
                    'price' => 15000,
                    'sale_price' => null,
                    'slug' => 'alat-kebersihan',
                ],
                (object) [
                    'title' => 'Alat Kesehatan',
                    'overview' => 'Peralatan kesehatan terpilih untuk klinik dan layanan kesehatan.',
                    'image' => 'images/hero/alatkesehatan.jpg',
                    'price' => 2000,
                    'sale_price' => null,
                    'slug' => 'alat-kesehatan',
                ],
                (object) [
                    'title' => 'Furniture Kantor',
                    'overview' => 'Kursi, meja, dan perlengkapan interior kantor modern.',
                    'image' => 'images/hero/furniturekantor.jpg',
                    'price' => 800000,
                    'sale_price' => null,
                    'slug' => 'furniture-kantor',
                ],
            ]);
        }
    @endphp


    <!-- Produk Pilihan Section -->
    <section class="py-20 bg-white">
        <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24">
            <!-- Header -->
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl text-gray-900 italic">Produk Pilihan Untuk Kebutuhan Anda</h2>
            </div>

            <!-- Products Slider -->
            <div class="relative" x-data="{
                scrollContainer: null,
                scrollLeft() {
                    this.scrollContainer.scrollBy({ left: -320, behavior: 'smooth' })
                },
                scrollRight() {
                    this.scrollContainer.scrollBy({ left: 320, behavior: 'smooth' })
                }
            }" x-init="scrollContainer = $refs.slider">

                <!-- Arrow Left -->
                <button @click="scrollLeft()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <!-- Arrow Right -->
                <button @click="scrollRight()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Products Container -->
                <div x-ref="slider" class="flex gap-4 overflow-x-auto scrollbar-hide scroll-smooth pb-4" style="scrollbar-width: none; -ms-overflow-style: none;">
                    @forelse($products as $prodIdx => $product)
                    @php
                        $prodImg = $product->image
                            ? (\Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])
                                ? $product->image
                                : (\Illuminate\Support\Str::startsWith($product->image, ['images/', 'img/', 'assets/'])
                                    ? asset($product->image)
                                    : asset('storage/' . $product->image)))
                            : asset('images/placeholder.jpg');
                        $prodPrice = $product->sale_price && $product->sale_price < $product->price
                            ? $product->sale_price
                            : $product->price;
                        $productRouteParams = ['slug' => $product->slug];
                        if (isset($page) && $page instanceof \App\Models\Page && !empty($page->id)) {
                            $productRouteParams['ctx'] = encrypt($page->id);
                        }

                        $prodUrl = \Illuminate\Support\Facades\Route::has('produk.show')
                            ? route('produk.show', $product->slug)
                            : (\Illuminate\Support\Facades\Route::has('products.detail')
                                ? route('products.detail', $productRouteParams)
                                : '#');
                    @endphp
                    <div class="group flex-shrink-0 w-[280px] card-lift" data-reveal data-reveal-delay="{{ $prodIdx + 1 }}">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ $prodImg }}" alt="{{ $product->title }}"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">{{ $product->title }}</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">{{ $product->overview ? \Illuminate\Support\Str::limit(strip_tags($product->overview), 30) : '' }}</p>
                                @if($prodPrice && $product->show_price)
                                <span class="text-sm font-medium text-gray-900">Rp {{ number_format($prodPrice, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <a href="{{ $prodUrl }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400 text-sm py-8">Belum ada produk</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endif

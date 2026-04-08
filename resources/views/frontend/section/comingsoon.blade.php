@if ($shortcode->type == 'comingsoon')
<section 
    class="relative w-full min-h-screen flex items-center justify-center overflow-hidden"
    x-data="{ loaded: false }"
>
    {{-- Background image (lazy) --}}
    <img 
        src="{{ Storage::url('media/coming-soon-banner-background_518299-12196.jpg') }}"
        {{-- src="{{ asset($shortcode->comingsoon_image) }}" --}}
        alt="Coming Soon Background"
        loading="lazy"
        @load="loaded = true"
        class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700"
        :class="loaded ? 'opacity-100' : 'opacity-0'"
    >

    {{-- Overlay (optional biar teks kebaca) --}}
    <div class="absolute inset-0 bg-black/40"></div>

    {{-- Content --}}
    <div class="relative z-10 max-w-2xl mx-auto text-center px-6 text-white">
        
        {{--
        <h1 class="text-5xl md:text-6xl font-bold mb-6">
            Coming Soon
        </h1>

        <p class="mb-6 text-lg text-gray-200">
            This page is currently under construction.
        </p>

        <a href="/" 
           class="inline-block px-6 py-3 rounded-xl bg-white text-black font-semibold hover:opacity-90 transition">
            Back to homepage
        </a>
        --}}
        
    </div>
</section>
@endif
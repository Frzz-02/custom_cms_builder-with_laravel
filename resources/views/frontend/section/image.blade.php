@if ($shortcode->type == 'image')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-center">
            <img src="{{ asset('storage/' . $shortcode->image) }}" 
                 alt="{{ $shortcode->title ?? 'Image' }}" 
                 class="max-w-full h-auto rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300"
                 loading="lazy">
        </div>
    </div>
@endif


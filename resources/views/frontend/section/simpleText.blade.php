@if ($shortcode->type == 'simple-text')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="max-w-4xl mx-auto">
            <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                {{ $shortcode->content }}
            </p>
        </div>
    </div>
@endif

@if ($shortcode->type == 'title')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-3xl mx-auto text-center">
            @if ($shortcode->subtitle)
                <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold tracking-wider text-blue-600 uppercase bg-blue-50 rounded-full">
                    {{ $shortcode->subtitle }}
                </span>
            @endif

            <{{ $shortcode->heading }} class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                {{ $shortcode->title }}
            </{{ $shortcode->heading }}>
        </div>
    </div>
@endif

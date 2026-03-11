@if ($shortcode->type == 'texteditor')
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto prose prose-lg prose-blue max-w-none">
            <div class="text-gray-800 leading-relaxed space-y-4">
                {!! $shortcode->content !!}
            </div>
        </div>
    </div>
@endif

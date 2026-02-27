@if ($shortcode->type == 'title')
    {{-- <{{ $shortcode->heading }}>{{ $shortcode->title }}</{{ $shortcode->heading }}>
                <p>{{ $shortcode->subtitle }}</p> --}}
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
            <div class="common-heading tagline-boxed-two title-line m-b-70 text-center">
                @if ($shortcode->subtitle)
                    <span class="tagline">{{ $shortcode->subtitle }}</span>
                @endif

                <h2 class="title">{{ $shortcode->title }}</h2>
            </div>
        </div>
    </div>
@endif

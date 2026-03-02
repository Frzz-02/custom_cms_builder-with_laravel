@if ($shortcode->type == 'image')
    <img src="{{ asset($shortcode->image) }}" alt="Image" class="img-fluid mx-auto d-block" width="100">
@endif


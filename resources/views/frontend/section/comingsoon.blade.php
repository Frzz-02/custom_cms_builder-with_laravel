@if ($shortcode->type == 'comingsoon')
    <section class="p-0 cover-background wow animate__fadeIn" style="background-image: url('{{ asset($shortcode->comingsoon_image) }}');">
        <div class="container">
            <div class="row align-items-stretch justify-content-center full-screen">
                <div class="col-xl-6 col-lg-7 col-md-8 text-center d-flex align-items-center justify-content-center flex-column">
                    {{-- <h6 class="alt-font text-fast-blue font-weight-600 letter-spacing-minus-1px margin-10px-bottom text-uppercase">Oops!</h6>
                    <h1 class="alt-font text-extra-big font-weight-700 letter-spacing-minus-5px text-extra-dark-gray margin-6-rem-bottom md-margin-4-rem-bottom">404</h1>
                    <span class="alt-font font-weight-500 text-extra-dark-gray d-block margin-20px-bottom">This page could not be found!</span>
                    <a href="/" class="btn btn-large btn-gradient-sky-blue-pink">Back to homepage</a> --}}
                </div>
            </div>
        </div>
    </section>
@endif

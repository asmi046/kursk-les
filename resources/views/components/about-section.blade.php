<section id="about" class="about" aria-label="О нас">
    <div class="container">
        <div class="about__inner">
            <div class="about__content">
                <h2 class="section-head">{{ $title }}</h2>
                <div class="text_styles">
                    {!! $text !!}
                </div>
            </div>
            <div class="about__media">
                <video class="about__video" controls poster="{{ asset('/video/main_present.webp') }}">
                    <source src="{{ asset('/video/davinir_present.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
</section>
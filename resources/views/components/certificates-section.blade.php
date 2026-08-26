<section id="certificates" class="certificates" aria-label="Награды и сертификаты">
    <div class="container">
        <h2 class="section-head">Награды и сертификаты</h2>

        <div class="certificates__slider keen-slider" id="certificates-slider" aria-label="Награды и сертификаты">
            @foreach($certificates as $certificate)
                <div class="certificates__slide keen-slider__slide">
                    <img src="{{ Storage::url($certificate->img) }}" alt="Сертификат {{ $loop->iteration }}" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>
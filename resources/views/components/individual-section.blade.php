<section id="individual" class="individual" aria-label="Индивидуальный заказ и именные изделия">
    <div class="container">
        <div class="individual__inner">
            <div class="individual__content">
                <h2 class="section-head">{{ $title }}</h2>
                <div class="individual__text">{!! $text !!}</div>
                <div class="individual__social">
                    <div class="individual__social-links">
                        @if($maxLink && $maxImg)
                            <a class="individual__social-link" href="{{ $maxLink }}" target="_blank"
                                rel="noopener noreferrer" aria-label="Написать в MAX">
                                <img src="{{ Storage::url($maxImg) }}" alt="MAX" width="44" height="44">
                            </a>
                        @endif
                        @if($tgLink && $tgImg)
                            <a class="individual__social-link" href="{{ $tgLink }}" target="_blank"
                                rel="noopener noreferrer" aria-label="Написать в Telegram">
                                <img src="{{ Storage::url($tgImg) }}" alt="Telegram" width="44" height="44">
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="individual__slider-wrap">
                <div class="individual__slider keen-slider" id="individual-slider"
                    aria-label="Примеры индивидуальных изделий">
                    @foreach($slides as $index => $slide)
                        <div class="individual__slide keen-slider__slide">
                            <img src="{{ Storage::url($slide->img) }}"
                                alt="Индивидуальное изделие из дерева — пример {{ $index + 1 }}" loading="lazy">
                        </div>
                    @endforeach
                </div>
                <div class="individual__nav">
                    <button class="slider-nav slider-nav--next slider-nav--round" type="button"
                        aria-label="Следующий слайд" data-slider-next="individual-slider">
                        <svg class="sprite_icon" aria-hidden="true" focusable="false">
                            <use xlink:href="#icon-arrow-individual"></use>
                        </svg>
                    </button>
                    <button class="slider-nav slider-nav--prev slider-nav--round" type="button"
                        aria-label="Предыдущий слайд" data-slider-prev="individual-slider">
                        <svg class="sprite_icon" aria-hidden="true" focusable="false">
                            <use xlink:href="#icon-arrow-individual"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
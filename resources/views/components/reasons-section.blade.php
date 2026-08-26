<section id="reasons" class="reasons" aria-label="Несколько причин обратиться к нам">
    <div class="container">
        <div class="reasons__inner">
            <div class="reasons__content">
                <h2 class="section-head">{{ $title }}</h2>
                <div class="reasons__list">
                    @foreach ($reasons as $reason)
                        <div class="reasons__item">
                            <h3 class="reasons__item-title">{{ $reason->title }}</h3>
                            <p class="reasons__item-text">{{ $reason->value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="reasons__media">
                <div class="reasons__grid">
                    @foreach ($media as $image)
                        <img src="{{ Storage::url($image->img) }}" alt="" loading="lazy" class="reasons__img">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

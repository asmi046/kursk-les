import 'keen-slider/keen-slider.css';
import KeenSlider from 'keen-slider';

function initSliders() {
    // Слайдер «Индивидуальный заказ» — с кнопками прокрутки
    const individualEl = document.querySelector('#individual-slider');
    if (individualEl) {
        const slider = new KeenSlider(individualEl, {
            loop: true,
            slides: { perView: 1 },
        });

        const prevBtn = document.querySelector('[data-slider-prev="individual-slider"]');
        const nextBtn = document.querySelector('[data-slider-next="individual-slider"]');

        prevBtn?.addEventListener('click', () => slider.prev());
        nextBtn?.addEventListener('click', () => slider.next());
    }

    // Слайдер «Награды и сертификаты» — автопрокрутка, без управления
    const certEl = document.querySelector('#certificates-slider');
    if (certEl) {
        let autoplay;
        const slider = new KeenSlider(certEl, {
            loop: true,
            slides: { perView: 5, spacing: 16 },
            breakpoints: {
                '(max-width: 820px)': { slides: { perView: 3, spacing: 12 } },
                '(max-width: 520px)': { slides: { perView: 2, spacing: 8 } },
            },
        });

        const startAutoplay = () => {
            autoplay = window.setInterval(() => slider.next(), 3500);
        };
        const stopAutoplay = () => window.clearInterval(autoplay);

        startAutoplay();
        certEl.addEventListener('mouseenter', stopAutoplay);
        certEl.addEventListener('mouseleave', startAutoplay);
        certEl.addEventListener('focusin', stopAutoplay);
        certEl.addEventListener('focusout', startAutoplay);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSliders);
} else {
    initSliders();
}

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

    // Слайдер «Товар» — фото товара
    const productEl = document.querySelector('#product-slider');
    if (productEl) {
        new KeenSlider(productEl, {
            loop: true,
            slides: { perView: 1, spacing: 0 },
        });
    }
}

function initReadmore() {
    document.querySelectorAll('[data-readmore-toggle]').forEach((btn) => {
        const description = btn.closest('.product__description');
        if (!description) {
            return;
        }
        const inner = description.querySelector('.product__description-inner');
        if (!inner) {
            return;
        }

        if (inner.scrollHeight <= inner.clientHeight + 1) {
            btn.style.display = 'none';
            return;
        }

        btn.addEventListener('click', () => {
            const isOpen = description.classList.toggle('is-expanded');
            btn.textContent = isOpen ? 'Свернуть' : 'Читать полностью';
        });
    });
}

function initQty() {
    document.querySelectorAll('[data-qty]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const wrap = btn.closest('.product__qty');
            const input = wrap?.querySelector('input[type="number"]');
            if (!input) {
                return;
            }
            const min = parseInt(input.min, 10) || 1;
            const step = btn.dataset.qty === '+' ? 1 : -1;
            const next = Math.max(min, (parseInt(input.value, 10) || min) + step);
            input.value = next;
        });
    });
}

function initProductPage() {
    initReadmore();
    initQty();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initSliders();
        initProductPage();
    });
} else {
    initSliders();
    initProductPage();
}

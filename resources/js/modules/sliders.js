import KeenSlider from 'keen-slider';

function initIndividualSlider(root = document) {
    const slider = root.querySelector('#individual-slider');
    if (!slider) {
        return;
    }

    const instance = new KeenSlider(slider, {
        loop: true,
        slides: { perView: 1 },
    });

    const prevBtn = root.querySelector('[data-slider-prev="individual-slider"]');
    const nextBtn = root.querySelector('[data-slider-next="individual-slider"]');

    prevBtn?.addEventListener('click', () => instance.prev());
    nextBtn?.addEventListener('click', () => instance.next());
}

function initCertificatesSlider(root = document) {
    const slider = root.querySelector('#certificates-slider');
    if (!slider) {
        return;
    }

    const instance = new KeenSlider(slider, {
        loop: true,
        slides: { perView: 5, spacing: 16 },
        breakpoints: {
            '(max-width: 820px)': { slides: { perView: 3, spacing: 12 } },
            '(max-width: 520px)': { slides: { perView: 2, spacing: 8 } },
        },
    });

    let autoplayId;

    const startAutoplay = () => {
        autoplayId = window.setInterval(() => instance.next(), 3500);
    };

    const stopAutoplay = () => {
        window.clearInterval(autoplayId);
    };

    startAutoplay();

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);
    slider.addEventListener('focusin', stopAutoplay);
    slider.addEventListener('focusout', startAutoplay);
}

function initProductSlider(root = document) {
    const slider = root.querySelector('#product-slider');
    if (!slider) {
        return;
    }

    new KeenSlider(slider, {
        loop: true,
        slides: { perView: 1, spacing: 0 },
    });
}

export function initSliders(root = document) {
    initIndividualSlider(root);
    initCertificatesSlider(root);
    initProductSlider(root);
}

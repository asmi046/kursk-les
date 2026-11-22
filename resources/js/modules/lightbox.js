/**
 * Легкий лайтбокс для просмотра изображений.
 *
 * Работает по data-атрибуту: на контейнере с изображениями ставится
 * data-lightbox (опционально data-lightbox-group="имя" для общей галереи).
 * Клик по изображению открывает оверлей с навигацией (стрелки, Esc, клик по
 * подложке закрывает).
 */
class Lightbox {
    constructor(root = document) {
        this.groups = new Map();
        this.current = null;

        root.querySelectorAll('[data-lightbox]').forEach((container) => {
            const groupName = container.dataset.lightboxGroup ?? `lb-${this.groups.size}`;
            const images = [...container.querySelectorAll('img')].map((img) => ({
                src: img.currentSrc || img.src,
                alt: img.alt ?? '',
            }));

            if (images.length === 0) {
                return;
            }

            this.groups.set(groupName, images);

            container.querySelectorAll('img').forEach((img) => {
                img.style.cursor = 'zoom-in';
                img.addEventListener('click', () => {
                    const index = [...container.querySelectorAll('img')].indexOf(img);
                    this.open(groupName, index);
                });
            });
        });

        if (this.groups.size > 0) {
            this.buildOverlay();
            document.addEventListener('keydown', (e) => this.onKeydown(e));
        }
    }

    buildOverlay() {
        this.overlay = document.createElement('div');
        this.overlay.className = 'lightbox';
        this.overlay.hidden = true;
        this.overlay.innerHTML = `
            <button class="lightbox__close" type="button" aria-label="Закрыть">&times;</button>
            <button class="lightbox__nav lightbox__nav--prev" type="button" aria-label="Предыдущее изображение">&#8249;</button>
            <figure class="lightbox__figure">
                <img class="lightbox__img" src="" alt="">
            </figure>
            <button class="lightbox__nav lightbox__nav--next" type="button" aria-label="Следующее изображение">&#8250;</button>
        `;
        document.body.appendChild(this.overlay);

        this.img = this.overlay.querySelector('.lightbox__img');

        this.overlay.addEventListener('click', (e) => {
            if (e.target === this.overlay) {
                this.close();
            }
        });
        this.overlay.querySelector('.lightbox__close').addEventListener('click', () => this.close());
        this.overlay.querySelector('.lightbox__nav--prev').addEventListener('click', () => this.show(-1));
        this.overlay.querySelector('.lightbox__nav--next').addEventListener('click', () => this.show(1));
    }

    open(group, index) {
        this.current = { group, index };
        this.overlay.hidden = false;
        document.body.style.overflow = 'hidden';
        this.render();
    }

    close() {
        this.overlay.hidden = true;
        document.body.style.overflow = '';
        this.current = null;
    }

    show(direction) {
        const images = this.groups.get(this.current.group);
        this.current.index = (this.current.index + direction + images.length) % images.length;
        this.render();
    }

    render() {
        const images = this.groups.get(this.current.group);
        const item = images[this.current.index];
        this.img.src = item.src;
        this.img.alt = item.alt;
    }

    onKeydown(e) {
        if (this.current === null) {
            return;
        }

        if (e.key === 'Escape') {
            this.close();
        } else if (e.key === 'ArrowLeft') {
            this.show(-1);
        } else if (e.key === 'ArrowRight') {
            this.show(1);
        }
    }
}

export function initLightbox(root = document) {
    return new Lightbox(root);
}

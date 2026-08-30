const DEFAULT_TEXT_OPEN = 'Читать полностью';
const DEFAULT_TEXT_CLOSE = 'Свернуть';

export function initReadmore(root = document) {
    root.querySelectorAll('[data-readmore-toggle]').forEach((button) => {
        const container = button.closest('[data-readmore]');
        const inner = container?.querySelector('[data-readmore-inner]');

        if (!container || !inner) {
            console.warn('[readmore] missing [data-readmore] container or [data-readmore-inner] for', button);
            return;
        }

        const textOpen = button.dataset.textOpen ?? DEFAULT_TEXT_OPEN;
        const textClose = button.dataset.textClose ?? DEFAULT_TEXT_CLOSE;

        const sync = () => {
            const expanded = container.classList.contains('is-expanded');
            button.hidden = expanded
                ? false
                : inner.scrollHeight - inner.clientHeight <= 1;
            button.textContent = expanded ? textClose : textOpen;
        };

        sync();

        if ('ResizeObserver' in window) {
            new ResizeObserver(sync).observe(inner);
        }

        button.addEventListener('click', () => {
            container.classList.toggle('is-expanded');
            sync();
        });
    });
}

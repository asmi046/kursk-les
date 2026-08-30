export function initQty(root = document) {
    root.querySelectorAll('[data-qty]').forEach((button) => {
        const wrap = button.closest('[data-qty-group]');
        const input = wrap?.querySelector('input[type="number"]');

        if (!wrap || !input) {
            console.warn('[qty] missing [data-qty-group] or number input for', button);
            return;
        }

        const step = button.dataset.qty === '+' ? 1 : -1;
        const min = Number.parseInt(input.min, 10) || 1;
        const max = Number.parseInt(input.max, 10) || Infinity;

        button.addEventListener('click', () => {
            const current = Number.parseInt(input.value, 10) || min;
            const next = Math.min(max, Math.max(min, current + step));
            if (next !== Number(input.value)) {
                input.value = next;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });
}

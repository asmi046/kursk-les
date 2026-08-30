export default class CatalogFilters {
    constructor(options = {}) {
        this.opts = {
            toggleSelector: options.toggleSelector ?? '[data-filters-toggle]',
            collapseSelector: options.collapseSelector ?? '[data-filters-collapse]',
            openClass: options.openClass ?? 'is-open',
        };

        this.toggles = document.querySelectorAll(this.opts.toggleSelector);

        if (this.toggles.length === 0) {
            return;
        }

        this._onClick = (event) => this._handleClick(event);

        this.toggles.forEach((btn) => {
            const targetId = btn.getAttribute('aria-controls');
            const target = targetId ? document.getElementById(targetId) : null;
            if (!target) {
                return;
            }
            btn.addEventListener('click', this._onClick);
        });
    }

    _handleClick(event) {
        const btn = event.currentTarget;
        const targetId = btn.getAttribute('aria-controls');
        const target = targetId ? document.getElementById(targetId) : null;
        if (!target) {
            return;
        }

        const isOpen = target.classList.toggle(this.opts.openClass);
        btn.setAttribute('aria-expanded', String(isOpen));
    }

    destroy() {
        this.toggles.forEach((btn) => {
            btn.removeEventListener('click', this._onClick);
        });
    }
}

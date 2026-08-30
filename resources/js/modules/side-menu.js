export default class SideMenu {
    constructor(rootSelector, options = {}) {
        this.root = document.querySelector(rootSelector);

        if (!this.root) {
            return;
        }

        this.opts = {
            toggleSelector: options.toggleSelector ?? '[data-menu-toggle]',
            shadowSelector: options.shadowSelector ?? '[data-menu-shadow]',
            openClass: options.openClass ?? 'is-open',
            bodyLockClass: options.bodyLockClass ?? 'is-menu-open',
        };

        this.shadow = this.root.querySelector(this.opts.shadowSelector);
        this.toggleButtons = document.querySelectorAll(this.opts.toggleSelector);
        this.isOpen = false;

        this._onShadowClick = () => this.close();
        this._onToggleClick = () => this.toggle();
        this._onKeydown = (event) => this._handleKeydown(event);

        if (this.shadow) {
            this.shadow.addEventListener('click', this._onShadowClick);
        }

        this.toggleButtons.forEach((button) => {
            button.addEventListener('click', this._onToggleClick);
        });

        document.addEventListener('keydown', this._onKeydown);
    }

    _handleKeydown(event) {
        if (event.key === 'Escape' && this.isOpen) {
            this.close();
        }
    }

    open() {
        if (this.isOpen || !this.root) {
            return;
        }

        this.isOpen = true;
        this.root.classList.add(this.opts.openClass);
        this.root.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add(this.opts.bodyLockClass);
        this._syncToggles(true);
    }

    close() {
        if (!this.isOpen || !this.root) {
            return;
        }

        this.isOpen = false;
        this.root.classList.remove(this.opts.openClass);
        this.root.setAttribute('aria-hidden', 'true');
        document.documentElement.classList.remove(this.opts.bodyLockClass);
        this._syncToggles(false);
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    _syncToggles(state) {
        this.toggleButtons.forEach((button) => {
            button.setAttribute('aria-expanded', String(state));
        });
    }

    destroy() {
        if (this.shadow) {
            this.shadow.removeEventListener('click', this._onShadowClick);
        }

        this.toggleButtons.forEach((button) => {
            button.removeEventListener('click', this._onToggleClick);
        });

        document.removeEventListener('keydown', this._onKeydown);
        document.documentElement.classList.remove(this.opts.bodyLockClass);
    }
}

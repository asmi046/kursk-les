<aside
    id="main_side_menue"
    class="side-menu"
    role="dialog"
    aria-modal="true"
    aria-hidden="true"
    aria-label="Главное меню"
>
    <div class="side-menu__shadow" data-menu-shadow></div>

    <nav class="side-menu__panel">
        <div class="side-menu__inner">
            <button
                type="button"
                class="side-menu__close"
                data-menu-toggle
                aria-expanded="false"
                aria-label="Закрыть меню"
            >
                <x-burger-icon />
            </button>

            <div class="side-menu__puncts">
                {{ $slot }}
            </div>
        </div>
    </nav>
</aside>

<button
    type="button"
    class="side-menu-toggle"
    data-menu-toggle
    aria-expanded="false"
    aria-controls="main_side_menue"
    aria-label="Открыть меню"
>
    <x-burger-icon />
</button>

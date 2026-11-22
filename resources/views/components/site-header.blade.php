<header class="site-header">
    <div class="container">
        <div class="site-header__inner">
            <a class="site-header__logo" href="{{ route('home') }}" aria-label="Курский Лес — на главную">
                <img src="{{ asset('/img/logo/logo.svg') }}" alt="Курский Лес" width="150" height="54">
            </a>

            <div class="site-header__menu">
                <nav aria-label="Главное меню">
                    <x-menues.puncts></x-menues.puncts>
                </nav>
            </div>

            <div class="site-header__lists">
                <div class="site-header__list-badges" data-header-lists></div>
                <div class="site-header__cart" data-cart-counter></div>
            </div>

            <div class="site-header__feedback">
                <a class="button button--light" href="#" data-feedback-open>Обратная связь</a>
            </div>

            <div class="site-header__actions">
                <a class="site-header__messenger" href="{{ contact('max_lnk') ?? '#' }}" target="_blank"
                    rel="noopener noreferrer" aria-label="Написать в MAX">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false">
                        <use xlink:href="#icon-max"></use>
                    </svg>
                </a>
                <a class="site-header__messenger" href="{{ contact('tg_lnk') ?? '#' }}" target="_blank"
                    rel="noopener noreferrer" aria-label="Написать в Telegram">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false">
                        <use xlink:href="#icon-tg"></use>
                    </svg>
                </a>
                <a class="site-header__messenger site-header__messenger--call"
                    href="tel:{{ phone_format(contact('phone') ?? '') }}" aria-label="Позвонить">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false">
                        <use xlink:href="#icon-call"></use>
                    </svg>
                </a>
            </div>

            <div class="site-header__contacts">
                <a href="tel:{{ phone_format(contact('phone') ?? '') }}">{{ contact('phone') }}</a>
                <a href="mailto:{{ contact('email') ?? '' }}">{{ contact('email') }}</a>
            </div>
        </div>
    </div>
</header>

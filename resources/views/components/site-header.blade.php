<header class="site-header">
    <div class="container">
        <div class="site-header__inner">
            <a class="site-header__logo" href="{{ route('home') }}" aria-label="Курский Лес — на главную">
                <img src="{{ asset('/img/logo/logo.svg') }}" alt="Курский Лес" width="150" height="54">
            </a>

            <div class="site-header__menu">
                <nav aria-label="Главное меню">
                    <ul>
                        <li><a href="{{ route('home') }}#categories">Категории</a></li>
                        <li><a href="{{ route('home') }}#shop">Магазин</a></li>
                        <li><a href="{{ route('home') }}#individual">Индивидуальный заказ</a></li>
                        <li><a href="{{ route('home') }}#projects">Проекты</a></li>
                        <li><a href="{{ route('home') }}#about">О нас</a></li>
                    </ul>
                </nav>
            </div>

            <div class="site-header__feedback">
                <a class="button button--light" href="#">Обратная связь</a>
            </div>

            <div class="site-header__actions">
                <a class="site-header__messenger" href="https://max.ru/" target="_blank" rel="noopener noreferrer"
                    aria-label="Написать в MAX">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false">
                        <use xlink:href="#icon-max"></use>
                    </svg>
                </a>
                <a class="site-header__messenger" href="https://t.me/" target="_blank" rel="noopener noreferrer"
                    aria-label="Написать в Telegram">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false">
                        <use xlink:href="#icon-tg"></use>
                    </svg>
                </a>
                <a class="site-header__messenger site-header__messenger--call" href="tel:+74712343090"
                    aria-label="Позвонить">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false">
                        <use xlink:href="#icon-call"></use>
                    </svg>
                </a>
            </div>

            <div class="site-header__contacts">
                <a href="tel:+74712343090">+7 (4712) 34-30-90</a>
                <a href="mailto:kursk-les@yandex.ru">kursk-les@yandex.ru</a>
            </div>
        </div>
    </div>
</header>

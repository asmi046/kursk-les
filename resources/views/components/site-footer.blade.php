<footer class="site-footer">
    <div class="container">
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <a class="site-footer__logo" href="{{ route('home') }}" aria-label="Курский Лес — на главную">
                    <img src="{{ asset('/img/logo/logo_white.svg') }}" alt="Курский Лес" width="160" height="64">
                </a>
                <p class="site-footer__about-text">
                    Производственная компания «Курский Лес». Изделия из массива дерева:
                    от наборов для творчества до индивидуальных заказов.
                </p>
                <div class="site-footer__social">
                    <a class="site-footer__messenger" href="https://t.me/" target="_blank" rel="noopener noreferrer" aria-label="Написать в Telegram">
                        <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-tg"></use></svg>
                    </a>
                    <a class="site-footer__messenger" href="https://max.ru/" target="_blank" rel="noopener noreferrer" aria-label="Написать в MAX">
                        <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-max"></use></svg>
                    </a>
                </div>
            </div>

            <nav class="site-footer__menu" aria-label="Категории">
                <h2 class="site-footer__col-title">Каталог</h2>
                <ul>
                    <li><a href="{{ route('home') }}#categories">Наборы</a></li>
                    <li><a href="{{ route('home') }}#categories">Разделочные доски</a></li>
                    <li><a href="{{ route('home') }}#categories">Торцевые изделия</a></li>
                    <li><a href="{{ route('home') }}#shop">Интернет-магазин</a></li>
                </ul>
            </nav>

            <nav class="site-footer__menu" aria-label="Информация">
                <h2 class="site-footer__col-title">Информация</h2>
                <ul>
                    <li><a href="{{ route('home') }}#individual">Индивидуальный заказ</a></li>
                    <li><a href="{{ route('home') }}#projects">Наши проекты</a></li>
                    <li><a href="{{ route('home') }}#about">О нас</a></li>
                    <li><a href="{{ route('home') }}#reasons">Преимущества</a></li>
                </ul>
            </nav>

            <div class="site-footer__contacts">
                <h2 class="site-footer__col-title">Контакты</h2>
                <a href="tel:+70000000000">+7 (000) 000-00-00</a>
                <a href="mailto:info@kursk-les.ru">info@kursk-les.ru</a>
                <p class="site-footer__about-text">г. Курск, Россия</p>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>© {{ date('Y') }} Курский Лес. Все права защищены.</span>
            <span>Изделия из натурального дерева ручной работы</span>
        </div>
    </div>
</footer>

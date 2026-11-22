<footer class="site-footer">
    <div class="container">
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <a class="site-footer__logo" href="{{ route('home') }}" aria-label="{{ contact('site_name') ?? 'Курский Лес' }} — на главную">
                    <img src="{{ asset('/img/logo/logo_white.svg') }}" alt="{{ contact('site_name') ?? 'Курский Лес' }}" width="160" height="64">
                </a>
            </div>

            <nav class="site-footer__menu" aria-label="Категории">
                <h2 class="site-footer__col-title">Каталог</h2>
                <x-menues.puncts name="Каталог в подвале"></x-menues.puncts>
            </nav>

            <nav class="site-footer__menu" aria-label="Информация">
                <h2 class="site-footer__col-title">Информация</h2>
                <x-menues.puncts name="Информация в подвале"></x-menues.puncts>
            </nav>

            <div class="site-footer__contacts">
                <h2 class="site-footer__col-title">Контакты</h2>
                @if($phone = contact('phone'))
                    <a href="tel:{{ phone_format($phone) }}">{{ $phone }}</a>
                @endif
                @if($email = contact('email'))
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                @endif
                @if($adress = contact('adress'))
                    <p class="site-footer__about-text">{{ $adress }}</p>
                @endif
                <div class="site-header__actions">
                    @if($maxLnk = contact('max_lnk'))
                        <a class="site-header__messenger" href="{{ $maxLnk }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Написать в MAX">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false">
                                <use xlink:href="#icon-max"></use>
                            </svg>
                        </a>
                    @endif
                    @if($tgLnk = contact('tg_lnk'))
                        <a class="site-header__messenger" href="{{ $tgLnk }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Написать в Telegram">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false">
                                <use xlink:href="#icon-tg"></use>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>© {{ date('Y') }} {{ contact('company_name') ?? 'Курский Лес' }}. Все права защищены.</span>
            <span>Изделия из натурального дерева ручной работы</span>
        </div>

        <nav class="site-footer__pages" aria-label="Правовая информация">
            <a href="{{ route('page.show', 'personal-data-policy') }}">Политика в области обработки персональных данных</a>
            <a href="{{ route('page.show', 'personal-data-consent') }}">Согласие на обработку персональных данных</a>
            <a href="{{ route('page.show', 'cookie') }}">О файлах cookie</a>
        </nav>
    </div>
</footer>

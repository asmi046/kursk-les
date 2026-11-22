<div class="feedback-modal" data-feedback-modal hidden>
    <div class="feedback-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="feedback-modal-title">
        <button class="feedback-modal__close" type="button" data-feedback-close aria-label="Закрыть окно">
            <svg class="sprite_icon" aria-hidden="true" focusable="false">
                <use xlink:href="#icon-close"></use>
            </svg>
        </button>

        <div class="feedback-modal__body">
            <h2 class="feedback-modal__title" id="feedback-modal-title">Обратная связь</h2>

            <form class="feedback-form" data-feedback-form action="{{ route('feedback.store') }}" novalidate>
                <div class="feedback-form__row">
                    <input class="feedback-form__input" type="tel" name="phone" data-phone-mask
                        placeholder="+7 (___) ___-__-__" autocomplete="tel" required>
                    <div class="feedback-form__error" data-feedback-error="phone" hidden></div>
                </div>

                <div class="feedback-form__consents">
                    <label class="cart-consents__item">
                        <input type="checkbox" name="policy" value="1">
                        <span>Я согласен с
                            <a href="{{ route('page.show', 'personal-data-policy') }}" target="_blank">политикой
                                обработки персональных данных</a> *
                        </span>
                    </label>
                    <label class="cart-consents__item">
                        <input type="checkbox" name="consent" value="1">
                        <span>Я даю
                            <a href="{{ route('page.show', 'personal-data-consent') }}" target="_blank">согласие на
                                обработку персональных данных</a> *
                        </span>
                    </label>
                    <div class="feedback-form__error" data-feedback-error="policy" hidden></div>
                    <div class="feedback-form__error" data-feedback-error="consent" hidden></div>
                </div>

                <div class="feedback-form__error" data-feedback-error="common" hidden></div>

                <button class="button feedback-form__submit" type="submit" data-feedback-submit>Отправить</button>
            </form>
        </div>

        <div class="feedback-modal__result" data-feedback-result hidden></div>
    </div>
</div>

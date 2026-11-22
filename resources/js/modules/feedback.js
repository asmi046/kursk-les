const PHONE_TEMPLATE = '+7 (___) ___-__-__';

const applyMask = (value) => {
    const digits = value.replace(/\D/g, '');

    if (digits === '') {
        return '';
    }

    const normalized = digits.startsWith('8') ? `7${digits.slice(1)}` : digits;
    const body = normalized.startsWith('7') ? normalized.slice(1) : normalized;

    let result = '+7';
    if (body.length > 0) {
        result += ` (${body.slice(0, 3)}`;
    }
    if (body.length >= 3) {
        result += ')';
    }
    if (body.length > 3) {
        result += ` ${body.slice(3, 6)}`;
    }
    if (body.length > 6) {
        result += `-${body.slice(6, 8)}`;
    }
    if (body.length > 8) {
        result += `-${body.slice(8, 10)}`;
    }

    return result;
};

const getCsrfToken = () => document.querySelector('meta[name="_token"]')?.getAttribute('content') ?? '';

export const initFeedback = () => {
    const modal = document.querySelector('[data-feedback-modal]');

    if (!modal) {
        return;
    }

    const form = modal.querySelector('[data-feedback-form]');
    const body = modal.querySelector('.feedback-modal__body');
    const result = modal.querySelector('[data-feedback-result]');
    const submitButton = modal.querySelector('[data-feedback-submit]');
    const phoneInput = modal.querySelector('[data-phone-mask]');
    const errorBlocks = modal.querySelectorAll('[data-feedback-error]');

    const setError = (field, message) => {
        const block = modal.querySelector(`[data-feedback-error="${field}"]`);

        if (!block) {
            return;
        }

        block.textContent = message;
        block.hidden = !message;
    };

    const clearErrors = () => {
        errorBlocks.forEach((block) => {
            block.textContent = '';
            block.hidden = true;
        });
    };

    const open = () => {
        modal.hidden = false;
        document.body.classList.add('is-menu-open');
        phoneInput?.focus();
    };

    const close = () => {
        modal.hidden = true;
        document.body.classList.remove('is-menu-open');
        reset();
    };

    const reset = () => {
        form.reset();
        form.hidden = false;
        body.hidden = false;
        result.hidden = true;
        result.textContent = '';
        result.classList.remove('feedback-modal__result--success', 'feedback-modal__result--error');
        submitButton.disabled = false;
        submitButton.textContent = 'Отправить';
        clearErrors();
    };

    document.querySelectorAll('[data-feedback-open]').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            open();
        });
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            close();
        }
    });

    modal.querySelectorAll('[data-feedback-close]').forEach((button) => {
        button.addEventListener('click', close);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.hidden) {
            close();
        }
    });

    phoneInput?.addEventListener('input', () => {
        phoneInput.value = applyMask(phoneInput.value);
        setError('phone', '');
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearErrors();

        submitButton.disabled = true;
        submitButton.textContent = 'Отправка…';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify({
                    phone: phoneInput.value,
                    policy: form.elements.policy.checked ? '1' : null,
                    consent: form.elements.consent.checked ? '1' : null,
                }),
            });

            const data = await response.json();

            if (!response.ok || data.success === false) {
                const errors = data.errors ?? {};

                Object.entries(errors).forEach(([field, messages]) => {
                    setError(field, messages[0] ?? '');
                });

                if (Object.keys(errors).length === 0) {
                    setError('common', data.message ?? 'Не удалось отправить заявку. Попробуйте ещё раз.');
                }

                submitButton.disabled = false;
                submitButton.textContent = 'Отправить';
                return;
            }

            form.hidden = true;
            result.textContent = data.message ?? 'Спасибо! Ваша заявка принята.';
            result.classList.add('feedback-modal__result--success');
            result.hidden = false;

            setTimeout(close, 4000);
        } catch (error) {
            setError('common', 'Не удалось отправить заявку. Попробуйте ещё раз.');
            submitButton.disabled = false;
            submitButton.textContent = 'Отправить';
        }
    });
};

/**
 * API-слой корзины и доставки. Запросы на fetch с CSRF-токеном
 * из <meta name="_token"> (уже есть в layouts/all.blade.php).
 */

const csrfToken = () => document.querySelector('meta[name="_token"]')?.content ?? '';

async function request(url, options = {}) {
    const response = await fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken(),
            ...(options.json !== undefined ? { 'Content-Type': 'application/json' } : {}),
        },
        ...options,
        body: options.json !== undefined ? JSON.stringify(options.json) : options.body,
    });

    const payload = await response.json().catch(() => ({}));

    if (!response.ok || payload.success === false) {
        const error = new Error(payload.message ?? 'Ошибка запроса');
        error.errors = payload.errors ?? {};
        throw error;
    }

    return payload.data;
}

export const cartApi = {
    get: () => request('/cart/api'),
    add: (data) => request('/cart/api/add', { method: 'POST', json: data }),
    update: (data) => request('/cart/api/update', { method: 'POST', json: data }),
    remove: (data) => request('/cart/api/delete', { method: 'DELETE', json: data }),
    clear: () => request('/cart/api/clear', { method: 'DELETE' }),
    checkout: (data) => request('/cart/api/checkout', { method: 'POST', json: data }),
};

export const deliveryApi = {
    cities: (city) => request(`/delivery/cities?city=${encodeURIComponent(city)}`),
    pickupPoints: (cityCode) =>
        request('/delivery/pickup-points', { method: 'POST', json: { city_code: cityCode } }),
    tariffs: (toCode, deliveryMode) =>
        request('/delivery/tariffs', { method: 'POST', json: { to_code: toCode, delivery_mode: deliveryMode } }),
};

export function formatPrice(value) {
    return `${Number(value ?? 0).toLocaleString('ru-RU')} ₽`;
}

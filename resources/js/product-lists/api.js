/**
 * API-слой избранного и сравнения. Тот же контракт ответа,
 * что и у корзины: { success, data }.
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

export const favoritesApi = {
    get: () => request('/favorites/api'),
    toggle: (data) => request('/favorites/api/toggle', { method: 'POST', json: data }),
    remove: (data) => request('/favorites/api/delete', { method: 'DELETE', json: data }),
    clear: () => request('/favorites/api/clear', { method: 'DELETE' }),
};

export const compareApi = {
    get: () => request('/compare/api'),
    toggle: (data) => request('/compare/api/toggle', { method: 'POST', json: data }),
    remove: (data) => request('/compare/api/delete', { method: 'DELETE', json: data }),
    clear: () => request('/compare/api/clear', { method: 'DELETE' }),
};

export function formatPrice(value) {
    return `${Number(value ?? 0).toLocaleString('ru-RU')} ₽`;
}

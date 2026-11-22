/**
 * Загрузчик Яндекс.Карт 2.1. Скрипт подключается один раз и кэшируется.
 * Ключ API опционален (window.Laravel.yandexMapKey, env YANDEX_MAP_KEY).
 */

let yandexApiPromise = null;

export function loadYandexMaps() {
    if (window.ymaps) {
        return Promise.resolve();
    }

    if (yandexApiPromise) {
        return yandexApiPromise;
    }

    const apiKey = window.Laravel?.yandexMapKey;
    const scriptSrc = `https://api-maps.yandex.ru/2.1/?lang=ru_RU${apiKey ? `&apikey=${apiKey}` : ''}`;

    yandexApiPromise = new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = scriptSrc;
        script.async = true;
        script.onload = () => window.ymaps.ready(() => resolve());
        script.onerror = () => {
            yandexApiPromise = null;
            reject(new Error('Не удалось загрузить Яндекс.Карты'));
        };
        document.head.appendChild(script);
    });

    return yandexApiPromise;
}

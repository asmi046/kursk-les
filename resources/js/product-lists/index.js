/**
 * Точка входа избранного и сравнения. Монтирует независимые
 * Vue-приложения на data-атрибуты; все шарят store из store.js,
 * поэтому информеры обновляются без перезагрузки страницы.
 *
 * - [data-list-toggle] — кнопка «В избранное / В сравнение»
 *   (data-type="favorite|compare", data-variant="card|product", data-product-id);
 * - [data-header-lists] — информеры избранного и сравнения в шапке;
 * - [data-compare-toolbar] — счётчик в тулбаре каталога (data-count — стартовое значение);
 * - #favorites_app / #compare_app — страницы списков.
 */

import { createApp } from 'vue';
import ComparePage from './components/ComparePage.vue';
import CompareToolbarCount from './components/CompareToolbarCount.vue';
import FavoritesPage from './components/FavoritesPage.vue';
import HeaderListBadges from './components/HeaderListBadges.vue';
import ListToggleButton from './components/ListToggleButton.vue';

const initProductLists = () => {
    document.querySelectorAll('[data-list-toggle]').forEach((element) => {
        createApp(ListToggleButton, {
            productId: element.dataset.productId,
            type: element.dataset.type,
            variant: element.dataset.variant ?? 'card',
        }).mount(element);
    });

    document.querySelectorAll('[data-header-lists]').forEach((element) => {
        createApp(HeaderListBadges).mount(element);
    });

    document.querySelectorAll('[data-compare-toolbar]').forEach((element) => {
        createApp(CompareToolbarCount, {
            initial: element.dataset.count ?? 0,
        }).mount(element);
    });

    const favoritesPage = document.getElementById('favorites_app');

    if (favoritesPage) {
        createApp(FavoritesPage).mount(favoritesPage);
    }

    const comparePage = document.getElementById('compare_app');

    if (comparePage) {
        createApp(ComparePage).mount(comparePage);
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProductLists, { once: true });
} else {
    initProductLists();
}

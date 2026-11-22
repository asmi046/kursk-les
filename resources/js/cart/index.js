/**
 * Точка входа корзины. Монтирует независимые Vue-приложения
 * на data-атрибуты; все шарят один cartStore (resources/js/cart/store.js),
 * поэтому виджет в шапке обновляется без перезагрузки страницы.
 */

import { createApp } from 'vue';
import CartAddButton from './components/CartAddButton.vue';
import CartCounter from './components/CartCounter.vue';
import CartPage from './components/CartPage.vue';

const initCart = () => {
    document.querySelectorAll('[data-cart-add]').forEach((element) => {
        let product = {};

        try {
            product = JSON.parse(element.dataset.cartAdd);
        } catch {
            return;
        }

        createApp(CartAddButton, {
            product,
            qtySelector: element.dataset.qtySelector ?? '',
        }).mount(element);
    });

    document.querySelectorAll('[data-cart-counter]').forEach((element) => {
        createApp(CartCounter).mount(element);
    });

    const cartPage = document.getElementById('cart_app');

    if (cartPage) {
        let payIcons = [];

        try {
            payIcons = JSON.parse(cartPage.dataset.payIcons ?? '[]');
        } catch {
            payIcons = [];
        }

        createApp(CartPage, {
            payIcons,
            policyUrl: cartPage.dataset.policyUrl,
            consentUrl: cartPage.dataset.consentUrl,
        }).mount(cartPage);
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCart, { once: true });
} else {
    initCart();
}

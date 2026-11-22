/**
 * Общий реактивный store корзины. Все Vue-приложения (кнопка товара,
 * виджет в шапке, страница корзины) монтируются из одного бандла
 * и шарят этот store, поэтому виджет обновляется без перезагрузки.
 */

import { reactive } from 'vue';
import { cartApi } from './api';

export const cartStore = reactive({
    loaded: false,
    loading: false,
    count: 0,
    items: [],
    items_summ: 0,
    weight_grams: 0,

    async load(force = false) {
        if (this.loading || (this.loaded && !force)) {
            return;
        }

        this.loading = true;

        try {
            this.apply(await cartApi.get());
            this.loaded = true;
        } finally {
            this.loading = false;
        }
    },

    async add(payload) {
        this.apply(await cartApi.add(payload));
    },

    async update(productId, color, quantity) {
        this.apply(await cartApi.update({ product_id: productId, color, quantity }));
    },

    async remove(productId, color) {
        this.apply(await cartApi.remove({ product_id: productId, color }));
    },

    async clear() {
        this.apply(await cartApi.clear());
    },

    apply(data) {
        this.count = data.count ?? 0;
        this.items = data.items ?? [];
        this.items_summ = data.items_summ ?? 0;
        this.weight_grams = data.weight_grams ?? 0;
    },
});

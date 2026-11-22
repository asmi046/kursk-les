/**
 * Общие реактивные store избранного и сравнения. Все Vue-приложения
 * (кнопки товара, информеры в шапке, тулбар каталога, страницы списков)
 * монтируются из одного бандла и шарят эти store.
 */

import { reactive } from 'vue';
import { compareApi, favoritesApi } from './api';

function createListStore(api) {
    return reactive({
        loaded: false,
        loading: false,
        count: 0,
        ids: [],
        items: [],

        async load(force = false) {
            if (this.loading || (this.loaded && !force)) {
                return;
            }

            this.loading = true;

            try {
                this.apply(await api.get());
                this.loaded = true;
            } finally {
                this.loading = false;
            }
        },

        async toggle(productId) {
            const data = await api.toggle({ product_id: productId });
            this.apply(data);

            return data;
        },

        async remove(productId) {
            this.apply(await api.remove({ product_id: productId }));
        },

        async clear() {
            this.apply(await api.clear());
        },

        isActive(productId) {
            return this.ids.includes(Number(productId));
        },

        apply(data) {
            this.count = data.count ?? 0;
            this.ids = data.ids ?? [];
            this.items = data.items ?? [];
        },
    });
}

export const favoritesStore = createListStore(favoritesApi);
export const compareStore = createListStore(compareApi);

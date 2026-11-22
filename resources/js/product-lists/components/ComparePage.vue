<template>
    <div v-if="compareStore.loaded && compareStore.items.length === 0" class="product-lists__empty">
        <p>В сравнении пока нет товаров.</p>
        <a class="button" :href="catalogUrl">Перейти в каталог</a>
    </div>

    <div v-else class="compare-table__wrap">
        <table class="compare-table">
            <thead>
                <tr>
                    <th class="compare-table__param" scope="row">Товар</th>
                    <th v-for="product in compareStore.items" :key="product.id" scope="col">
                        <div class="compare-table__product">
                            <a class="compare-table__img" :href="product.url">
                                <img v-if="product.img" :src="product.img" :alt="product.title" loading="lazy">
                            </a>
                            <a class="compare-table__title" :href="product.url">{{ product.title }}</a>
                            <button class="compare-table__remove" type="button"
                                :aria-label="`Убрать из сравнения: ${product.title}`" :disabled="pending === product.id"
                                @click="remove(product.id)">
                                <svg class="sprite_icon" aria-hidden="true" focusable="false">
                                    <use xlink:href="#icon-close"></use>
                                </svg>
                                <span>Убрать</span>
                            </button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="row.label">
                    <th class="compare-table__param" scope="row">{{ row.label }}</th>
                    <td v-for="product in compareStore.items" :key="product.id">
                        {{ row.value(product) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { formatPrice } from '../api';
import { compareStore } from '../store';

const catalogUrl = '/catalog';

const pending = ref(null);

const yesNo = (value) => (value ? 'Есть' : 'Нет');

const rows = [
    { label: 'Цена', value: (product) => formatPrice(product.price) },
    { label: 'Тип', value: (product) => product.type || '—' },
    { label: 'Материал', value: (product) => product.material || '—' },
    { label: 'Модель', value: (product) => product.model || '—' },
    { label: 'Габариты (Д×Ш×В)', value: (product) => product.dimensions || '—' },
    { label: 'Вес', value: (product) => product.weight || '—' },
    { label: 'Ручка', value: (product) => yesNo(product.handle_exist) },
    { label: 'Эффект ржавчины', value: (product) => yesNo(product.rust_exist) },
];

onMounted(() => compareStore.load(true));

async function remove(productId) {
    pending.value = productId;

    try {
        await compareStore.remove(productId);
    } finally {
        pending.value = null;
    }
}
</script>

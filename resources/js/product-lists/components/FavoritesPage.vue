<template>
    <div v-if="favoritesStore.loaded && favoritesStore.items.length === 0" class="product-lists__empty">
        <p>В избранном пока пусто.</p>
        <a class="button" :href="catalogUrl">Перейти в каталог</a>
    </div>

    <div v-else class="shop__grid product-lists__grid">
        <article v-for="product in favoritesStore.items" :key="product.id" class="product-card">
            <a class="product-card__link" :href="product.url" :aria-label="product.title">{{ product.title }}</a>
            <div class="product-card__media">
                <img v-if="product.img" :src="product.img" :alt="product.title" loading="lazy">
            </div>
            <div class="product-card__body">
                <div class="product-card__title">{{ product.title }}</div>
                <div class="product-card__price">{{ formatPrice(product.price) }}</div>

                <div class="product-card__controls">
                    <button class="product-card__control is-active" type="button"
                        :aria-label="`Убрать из избранного: ${product.title}`" :disabled="pending === product.id"
                        @click="remove(product.id)">
                        <svg class="sprite_icon" aria-hidden="true" focusable="false">
                            <use xlink:href="#icon-favorite"></use>
                        </svg>
                        <span>Убрать</span>
                    </button>
                </div>

                <div class="product-card__footer">
                    <button class="button" type="button" :disabled="pendingCart === product.id"
                        :aria-label="`Добавить в корзину: ${product.title}`" @click="addToCart(product)">
                        <svg class="sprite_icon" aria-hidden="true" focusable="false">
                            <use xlink:href="#icon-bag"></use>
                        </svg>
                        <span>В корзину</span>
                    </button>
                </div>
            </div>
        </article>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { cartStore } from '../../cart/store';
import { formatPrice } from '../api';
import { favoritesStore } from '../store';

const catalogUrl = '/catalog';

const pending = ref(null);
const pendingCart = ref(null);

onMounted(() => favoritesStore.load(true));

async function remove(productId) {
    pending.value = productId;

    try {
        await favoritesStore.remove(productId);
    } finally {
        pending.value = null;
    }
}

async function addToCart(product) {
    pendingCart.value = product.id;

    try {
        await cartStore.add({ product_id: product.id, color: null, quantity: 1 });
    } finally {
        pendingCart.value = null;
    }
}
</script>

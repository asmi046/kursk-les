<template>
    <a class="cart-counter" :href="cartUrl" aria-label="Корзина">
        <svg class="sprite_icon" aria-hidden="true" focusable="false">
            <use xlink:href="#icon-bag"></use>
        </svg>
        <span v-if="cartStore.count > 0" class="cart-counter__badge">{{ cartStore.count }}</span>
    </a>
</template>

<script setup>
import { onMounted } from 'vue';
import { cartStore } from '../store';

const cartUrl = '/cart';

onMounted(() => cartStore.load());
</script>

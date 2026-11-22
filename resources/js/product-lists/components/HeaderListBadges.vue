<template>
    <a class="list-counter" :href="favoritesUrl" aria-label="Избранное">
        <svg class="sprite_icon" aria-hidden="true" focusable="false">
            <use xlink:href="#icon-favorite"></use>
        </svg>
        <span v-if="favoritesStore.count > 0" class="list-counter__badge">{{ favoritesStore.count }}</span>
    </a>
    <a class="list-counter" :href="compareUrl" aria-label="Сравнение">
        <svg class="sprite_icon" aria-hidden="true" focusable="false">
            <use xlink:href="#icon-compare"></use>
        </svg>
        <span v-if="compareStore.count > 0" class="list-counter__badge">{{ compareStore.count }}</span>
    </a>
</template>

<script setup>
import { onMounted } from 'vue';
import { compareStore, favoritesStore } from '../store';

const favoritesUrl = '/favorites';
const compareUrl = '/compare';

onMounted(() => {
    favoritesStore.load();
    compareStore.load();
});
</script>

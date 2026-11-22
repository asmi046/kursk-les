<template>
    <span>{{ text }}</span>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { compareStore } from '../store';

const props = defineProps({
    initial: { type: [Number, String], default: 0 },
});

const text = computed(() => (compareStore.loaded ? compareStore.count : Number(props.initial) || 0));

onMounted(() => compareStore.load());
</script>

<template>
    <button :class="[variantClass, { 'is-active': active }]" type="button" :aria-label="ariaLabel"
        :aria-pressed="active" :disabled="pending" @click="onToggle">
        <svg class="sprite_icon" aria-hidden="true" focusable="false">
            <use :xlink:href="iconId"></use>
        </svg>
        <span>{{ labelText }}</span>
    </button>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { compareStore, favoritesStore } from '../store';

const props = defineProps({
    productId: { type: [Number, String], required: true },
    type: { type: String, required: true }, // favorite | compare
    variant: { type: String, default: 'card' }, // card | product
});

const pending = ref(false);
const touched = ref(false);

const store = computed(() => (props.type === 'compare' ? compareStore : favoritesStore)).value;

const config = computed(() => {
    const isCompare = props.type === 'compare';
    const isCard = props.variant === 'card';

    return {
        iconId: isCompare ? '#icon-compare' : '#icon-favorite',
        addText: isCompare ? (isCard ? 'Сравнить' : 'В сравнение') : 'В избранное',
        removeText: isCompare ? 'В сравнении' : 'В избранном',
        ariaAdd: isCompare ? 'Добавить в сравнение' : 'Добавить в избранное',
        ariaRemove: isCompare ? 'Убрать из сравнения' : 'Убрать из избранного',
    };
});

const variantClass = computed(() => (props.variant === 'product' ? 'product__action' : 'product-card__control'));

const active = computed(() => store.isActive(props.productId));

const labelText = computed(() => {
    const isActive = active.value && (store.loaded || touched.value);

    return isActive ? config.value.removeText : config.value.addText;
});

const ariaLabel = computed(() => (active.value ? config.value.ariaRemove : config.value.ariaAdd));

const iconId = computed(() => config.value.iconId);

onMounted(() => store.load());

async function onToggle() {
    if (pending.value) {
        return;
    }

    pending.value = true;

    try {
        touched.value = true;
        await store.toggle(props.productId);
    } finally {
        pending.value = false;
    }
}
</script>

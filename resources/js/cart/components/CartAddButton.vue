<template>
    <button class="button" type="button" :disabled="adding" @click="open">
        <svg class="sprite_icon" aria-hidden="true" focusable="false">
            <use xlink:href="#icon-bag"></use>
        </svg>
        <span>В корзину</span>
    </button>

    <AddToCartModal
        v-if="added"
        v-model="modalOpen"
        :product="product"
        :initial-color="addedColor"
        :initial-quantity="addedQuantity"
    />
</template>

<script setup>
import { ref } from 'vue';
import { cartStore } from '../store';
import AddToCartModal from './AddToCartModal.vue';

const props = defineProps({
    product: { type: Object, required: true },
    qtySelector: { type: String, default: '' },
});

const adding = ref(false);
const added = ref(false);
const modalOpen = ref(false);
const addedColor = ref(null);
const addedQuantity = ref(1);

function externalQuantity() {
    if (!props.qtySelector) {
        return 1;
    }

    const input = document.querySelector(`${props.qtySelector} input[name="qty"]`);

    return Math.min(Math.max(parseInt(input?.value, 10) || 1, 1), 999);
}

async function open() {
    const color = props.product.colors?.[0] ?? null;
    const quantity = externalQuantity();

    adding.value = true;

    try {
        await cartStore.add({ product_id: props.product.id, color, quantity });
        addedColor.value = color;
        addedQuantity.value = quantity;
        added.value = true;
        modalOpen.value = true;
    } finally {
        adding.value = false;
    }
}
</script>

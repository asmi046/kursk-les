<template>
    <Teleport to="body">
        <div v-if="modelValue" class="cart-modal" @click.self="close">
            <div class="cart-modal__dialog" role="dialog" aria-modal="true" aria-label="Товар добавлен в корзину">
                <button class="cart-modal__close" type="button" aria-label="Закрыть" @click="close">
                    <svg class="sprite_icon" aria-hidden="true">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </button>

                <h2 class="cart-modal__title">Товар добавлен в корзину</h2>

                <div class="cart-modal__product">
                    <a class="cart-modal__img" :href="product.url">
                        <img :src="product.img" :alt="product.title">
                    </a>
                    <div class="cart-modal__info">
                        <a class="cart-modal__name" :href="product.url">{{ product.title }}</a>
                        <div v-if="product.characteristic" class="cart-modal__char">{{ product.characteristic }}</div>
                        <div class="cart-modal__price">{{ formatPrice(product.price) }}</div>
                    </div>
                </div>

                <div v-if="product.colors?.length" class="cart-modal__colors">
                    <div class="cart-modal__label">Цвет</div>
                    <label
                        v-for="color in product.colors"
                        :key="color"
                        class="cart-modal__color-option"
                        :class="{ 'cart-modal__color-option--active': color === selectedColor }"
                    >
                        <input
                            type="radio"
                            name="cart-modal-color"
                            :value="color"
                            :checked="color === selectedColor"
                            @change="changeColor(color)"
                        >
                        <span>{{ color }}</span>
                    </label>
                </div>

                <div class="cart-modal__qty">
                    <div class="cart-modal__label">Количество</div>
                    <div class="product__qty">
                        <button class="product__qty-btn" type="button" @click="changeQty(quantity - 1)">−</button>
                        <input
                            class="product__qty-input"
                            type="number"
                            :value="quantity"
                            min="1"
                            max="999"
                            @change="changeQty($event.target.value)"
                        >
                        <button class="product__qty-btn" type="button" @click="changeQty(quantity + 1)">+</button>
                    </div>
                </div>

                <div class="cart-modal__actions">
                    <a class="button" :href="cartUrl" @click="close">Оформить</a>
                    <button class="button button--outline" type="button" @click="close">Продолжить покупки</button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, watch } from 'vue';
import { cartStore } from '../store';
import { formatPrice } from '../api';

const props = defineProps({
    modelValue: { type: Boolean, default: false },
    product: { type: Object, required: true },
    initialColor: { type: String, default: null },
    initialQuantity: { type: Number, default: 1 },
});

const emit = defineEmits(['update:modelValue']);

const cartUrl = '/cart';
const selectedColor = ref(props.initialColor);
const quantity = ref(props.initialQuantity);

watch(
    () => props.modelValue,
    (open) => {
        if (open) {
            selectedColor.value = props.initialColor;
            quantity.value = props.initialQuantity;
        }
    },
);

function close() {
    emit('update:modelValue', false);
}

async function changeColor(color) {
    if (color === selectedColor.value) {
        return;
    }

    const previousColor = selectedColor.value;

    selectedColor.value = color;
    await cartStore.remove(props.product.id, previousColor);
    await cartStore.add({ product_id: props.product.id, color, quantity: quantity.value });
}

async function changeQty(value) {
    const next = Math.min(Math.max(parseInt(value, 10) || 1, 1), 999);

    quantity.value = next;
    await cartStore.update(props.product.id, selectedColor.value, next);
}
</script>

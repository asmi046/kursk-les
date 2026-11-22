<template>
    <Teleport to="body">
        <div v-if="modelValue" class="cart-modal" @click.self="close">
            <div class="cart-modal__dialog" role="dialog" aria-modal="true" aria-label="Курьерская доставка">
                <button class="cart-modal__close" type="button" aria-label="Закрыть" @click="close">
                    <svg class="sprite_icon" aria-hidden="true">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </button>

                <h2 class="cart-modal__title">Курьер СДЭК</h2>

                <div class="cart-form__row">
                    <div class="cart-modal__label">Город</div>
                    <CitySelect v-model="selectedCity" />
                </div>

                <div class="cart-form__row">
                    <div class="cart-modal__label">Улица</div>
                    <input v-model="street" class="cart-form__input" type="text" placeholder="Улица">
                </div>

                <div class="cart-form__grid">
                    <div class="cart-form__row">
                        <div class="cart-modal__label">Дом</div>
                        <input v-model="house" class="cart-form__input" type="text" placeholder="Дом">
                    </div>
                    <div class="cart-form__row">
                        <div class="cart-modal__label">Квартира</div>
                        <input v-model="apartment" class="cart-form__input" type="text" placeholder="Квартира">
                    </div>
                </div>

                <div v-if="error" class="cart-form__error">{{ error }}</div>

                <div class="cart-modal__actions">
                    <button
                        class="button"
                        type="button"
                        :disabled="!canConfirm || tariffLoading"
                        @click="confirm"
                    >
                        <template v-if="tariffLoading">Расчёт стоимости…</template>
                        <template v-else-if="tariff">Выбрать — {{ formatPrice(tariff.delivery_sum) }}</template>
                        <template v-else>Рассчитать и выбрать</template>
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { computed, ref } from 'vue';
import CitySelect from './CitySelect.vue';
import { deliveryApi, formatPrice } from '../api';

const emit = defineEmits(['update:modelValue', 'select']);

defineProps({
    modelValue: { type: Boolean, default: false },
});

const selectedCity = ref(null);
const street = ref('');
const house = ref('');
const apartment = ref('');
const tariff = ref(null);
const tariffLoading = ref(false);
const error = ref('');

const canConfirm = computed(
    () => selectedCity.value && street.value.trim() && house.value.trim(),
);

async function confirm() {
    if (!canConfirm.value) {
        return;
    }

    tariffLoading.value = true;
    error.value = '';

    try {
        tariff.value = await deliveryApi.tariffs(selectedCity.value.code, 3);

        if (!tariff.value || !tariff.value.delivery_sum) {
            error.value = 'Курьерская доставка в этот город недоступна.';
            return;
        }

        emit('select', {
            method: 'courier',
            price: tariff.value.delivery_sum,
            city: selectedCity.value.city,
            street: street.value.trim(),
            house: house.value.trim(),
            apartment: apartment.value.trim() || null,
            raw_data: {
                tariff: tariff.value,
                selectedCity: { code: selectedCity.value.code, city: selectedCity.value.city },
            },
        });
        emit('update:modelValue', false);
    } catch {
        error.value = 'Не удалось рассчитать стоимость доставки.';
    } finally {
        tariffLoading.value = false;
    }
}

function close() {
    emit('update:modelValue', false);
}
</script>

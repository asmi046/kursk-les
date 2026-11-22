<template>
    <div class="city-select" v-click-outside="close">
        <input
            class="city-select__input"
            type="text"
            :placeholder="placeholder"
            :value="search"
            @input="onInput($event.target.value)"
            @focus="open = true"
        >

        <div v-if="open" class="city-select__list">
            <div v-if="loading" class="city-select__item city-select__item--muted">Поиск города…</div>
            <template v-else>
                <div v-if="cities.length === 0" class="city-select__item city-select__item--muted">
                    Ничего не найдено
                </div>
                <button
                    v-for="city in cities"
                    :key="city.code"
                    class="city-select__item"
                    type="button"
                    @click="select(city)"
                >
                    {{ city.city }}{{ city.region ? `, ${city.region}` : '' }}
                </button>
            </template>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { deliveryApi } from '../api';

const props = defineProps({
    modelValue: { type: Object, default: null },
    placeholder: { type: String, default: 'Начните вводить город' },
});

const emit = defineEmits(['update:modelValue', 'select']);

const vClickOutside = {
    mounted(el, binding) {
        el.__clickOutside = (event) => {
            if (!el.contains(event.target)) {
                binding.value();
            }
        };
        document.addEventListener('click', el.__clickOutside);
    },
    unmounted(el) {
        document.removeEventListener('click', el.__clickOutside);
    },
};

const search = ref(props.modelValue ? props.modelValue.city : '');
const cities = ref([]);
const loading = ref(false);
const open = ref(false);
let debounce = null;

watch(
    () => props.modelValue,
    (value) => {
        if (value && value.city !== search.value) {
            search.value = value.city;
        }
    },
);

function onInput(value) {
    search.value = value;
    open.value = true;
    clearTimeout(debounce);

    if (value.length < 2) {
        cities.value = [];
        return;
    }

    debounce = setTimeout(fetchCities, 350);
}

async function fetchCities() {
    loading.value = true;

    try {
        cities.value = await deliveryApi.cities(search.value);
    } catch {
        cities.value = [];
    } finally {
        loading.value = false;
    }
}

function select(city) {
    search.value = city.city;
    open.value = false;
    emit('update:modelValue', city);
    emit('select', city);
}

function close() {
    open.value = false;
}
</script>

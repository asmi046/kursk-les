<template>
    <Teleport to="body">
        <div v-if="modelValue" class="cart-modal cart-modal--wide" @click.self="close">
            <div class="cart-modal__dialog" role="dialog" aria-modal="true" aria-label="Выбор пункта выдачи">
                <button class="cart-modal__close" type="button" aria-label="Закрыть" @click="close">
                    <svg class="sprite_icon" aria-hidden="true">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </button>

                <h2 class="cart-modal__title">Пункт выдачи СДЭК</h2>

                <div class="pickup-modal__city">
                    <CitySelect v-model="selectedCity" @select="onCitySelect" />
                </div>

                <div v-if="error" class="cart-form__error">{{ error }}</div>

                <div v-if="selectedCity" class="pickup-modal__body">
                    <div ref="mapContainer" class="pickup-modal__map"></div>

                    <div class="pickup-modal__list">
                        <div v-if="loading" class="pickup-modal__list-empty">Загрузка пунктов выдачи…</div>
                        <div v-else-if="points.length === 0" class="pickup-modal__list-empty">
                            В этом городе нет пунктов выдачи
                        </div>
                        <template v-else>
                            <button
                                v-for="point in points"
                                :key="point.code"
                                class="pickup-modal__point"
                                :class="{ 'pickup-modal__point--active': selectedPoint?.code === point.code }"
                                type="button"
                                @click="selectPoint(point)"
                            >
                                <span class="pickup-modal__point-address">{{ point.address }}</span>
                                <span v-if="point.work_time" class="pickup-modal__point-meta">{{ point.work_time }}</span>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="cart-modal__actions">
                    <button
                        class="button"
                        type="button"
                        :disabled="!selectedPoint || tariffLoading"
                        @click="confirm"
                    >
                        <template v-if="tariffLoading">Расчёт стоимости…</template>
                        <template v-else-if="tariff">
                            Выбрать — {{ formatPrice(tariff.delivery_sum) }}
                        </template>
                        <template v-else>Выбрать пункт</template>
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { nextTick, ref, watch } from 'vue';
import CitySelect from './CitySelect.vue';
import { deliveryApi, formatPrice } from '../api';
import { loadYandexMaps } from '../composables/yandexMaps';

const emit = defineEmits(['update:modelValue', 'select']);

const props = defineProps({
    modelValue: { type: Boolean, default: false },
});

const selectedCity = ref(null);
const selectedPoint = ref(null);
const points = ref([]);
const loading = ref(false);
const tariffLoading = ref(false);
const tariff = ref(null);
const error = ref('');
const mapContainer = ref(null);

let map = null;
let mapObjects = null;
let placemarks = {};

const DEFAULT_CITY = { code: 44, city: 'Москва', region: 'Москва' };

watch(() => props.modelValue, (open) => {
    if (open) {
        error.value = '';
        tariff.value = null;

        // Москва по умолчанию, чтобы виджет не выглядел пустым
        if (!selectedCity.value) {
            selectedCity.value = DEFAULT_CITY;
            onCitySelect();
        }
    }
});

async function onCitySelect() {
    selectedPoint.value = null;
    tariff.value = null;
    points.value = [];
    loading.value = true;
    error.value = '';

    try {
        points.value = await deliveryApi.pickupPoints(selectedCity.value.code);
        await nextTick();
        await renderMap();
    } catch {
        error.value = 'Не удалось загрузить пункты выдачи. Попробуйте другой город.';
    } finally {
        loading.value = false;
    }
}

async function renderMap() {
    const withCoords = points.value.filter((point) => point.latitude && point.longitude);

    if (withCoords.length === 0) {
        return;
    }

    try {
        await loadYandexMaps();
    } catch {
        error.value = 'Не удалось загрузить карту. Выберите пункт из списка справа.';
        return;
    }

    if (!map) {
        map = new window.ymaps.Map(mapContainer.value, {
            center: [withCoords[0].latitude, withCoords[0].longitude],
            zoom: 11,
            controls: ['zoomControl'],
        });
        mapObjects = new window.ymaps.GeoObjectCollection();
        map.geoObjects.add(mapObjects);
    }

    mapObjects.removeAll();
    placemarks = {};

    const bounds = [];

    points.value.forEach((point) => {
        if (!point.latitude || !point.longitude) {
            return;
        }

        const placemark = new window.ymaps.Placemark(
            [point.latitude, point.longitude],
            { balloonContent: point.address },
            { preset: 'islands#greenIcon' },
        );

        placemark.events.add('click', () => selectPoint(point));
        mapObjects.add(placemark);
        placemarks[point.code] = placemark;
        bounds.push([point.latitude, point.longitude]);
    });

    if (bounds.length > 1) {
        map.setBounds(window.ymaps.util.bounds.fromPoints(bounds), { checkZoomRange: true });
    } else {
        map.setCenter(bounds[0], 14);
    }
}

function selectPoint(point) {
    selectedPoint.value = point;
    tariff.value = null;
    error.value = '';

    Object.values(placemarks).forEach((placemark) => placemark.options.set('preset', 'islands#greenIcon'));

    if (placemarks[point.code]) {
        placemarks[point.code].options.set('preset', 'islands#redIcon');
        map?.panTo([point.latitude, point.longitude]);
    }
}

async function confirm() {
    if (!selectedPoint.value || !selectedCity.value) {
        return;
    }

    tariffLoading.value = true;
    error.value = '';

    try {
        tariff.value = await deliveryApi.tariffs(selectedCity.value.code, 4);

        if (!tariff.value || !tariff.value.delivery_sum) {
            error.value = 'Не удалось рассчитать стоимость доставки для этого пункта.';
            return;
        }

        emit('select', {
            method: 'pickup_point',
            price: tariff.value.delivery_sum,
            city: selectedCity.value.city,
            pickup_point_id: selectedPoint.value.code,
            pickup_point_address: selectedPoint.value.address,
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

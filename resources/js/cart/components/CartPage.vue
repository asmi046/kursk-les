<template>
    <section id="cart" class="cart-page section__first">
        <div class="container">
            <h1 class="section-head section-head--line section-head--top_space">Корзина</h1>

            <div v-if="!cartStore.loaded" class="cart-page__empty">Загрузка корзины…</div>

            <template v-else-if="cartStore.items.length > 0">
                <div class="cart-page__layout">
                    <div class="cart-page__main">
                        <div class="cart-page__items">
                            <article v-for="item in cartStore.items" :key="item.key" class="cart-item">
                                <a class="cart-item__img" :href="item.url">
                                    <img :src="item.img" :alt="item.title">
                                </a>

                                <div class="cart-item__info">
                                    <a class="cart-item__title" :href="item.url">{{ item.title }}</a>
                                    <div v-if="item.characteristic" class="cart-item__char">{{ item.characteristic }}</div>

                                    <label v-if="item.colors?.length" class="cart-item__color">
                                        <span>Цвет:</span>
                                        <select
                                            class="cart-form__input cart-form__input--select"
                                            :value="item.color"
                                            @change="changeItemColor(item, $event.target.value)"
                                        >
                                            <option v-for="color in item.colors" :key="color" :value="color">
                                                {{ color }}
                                            </option>
                                        </select>
                                    </label>
                                </div>

                                <div class="cart-item__qty product__qty">
                                    <button class="product__qty-btn" type="button"
                                        @click="updateItem(item, item.quantity - 1)">−</button>
                                    <input class="product__qty-input" type="number" :value="item.quantity" min="1"
                                        max="999" @change="updateItem(item, $event.target.value)">
                                    <button class="product__qty-btn" type="button"
                                        @click="updateItem(item, item.quantity + 1)">+</button>
                                </div>

                                <div class="cart-item__price">
                                    <div class="cart-item__summ">{{ formatPrice(item.summ) }}</div>
                                    <div class="cart-item__one">{{ formatPrice(item.price) }} / шт</div>
                                </div>

                                <button class="cart-item__remove" type="button" aria-label="Удалить из корзины"
                                    @click="removeItem(item)">
                                    <svg class="sprite_icon" aria-hidden="true">
                                        <use xlink:href="#icon-close"></use>
                                    </svg>
                                </button>
                            </article>
                        </div>

                        <button class="cart-page__clear" type="button" :disabled="cartStore.loading"
                            @click="clearCart">
                            <svg class="sprite_icon" aria-hidden="true">
                                <use xlink:href="#icon-trash"></use>
                            </svg>
                            <span>Очистить корзину</span>
                        </button>

                        <form class="cart-form" @submit.prevent="submit">
                            <h2 class="cart-form__title">Данные покупателя</h2>

                            <div class="cart-form__grid">
                                <div class="cart-form__row">
                                    <label class="cart-modal__label" for="cart-name">ФИО *</label>
                                    <input id="cart-name" v-model="form.name" class="cart-form__input" type="text"
                                        :class="{ 'cart-form__input--error': errors.name }" autocomplete="name">
                                    <div v-if="errors.name" class="cart-form__error">{{ errors.name[0] }}</div>
                                </div>
                                <div class="cart-form__row">
                                    <label class="cart-modal__label" for="cart-phone">Телефон *</label>
                                    <input id="cart-phone" v-model="form.phone" class="cart-form__input" type="tel"
                                        :class="{ 'cart-form__input--error': errors.phone }" autocomplete="tel">
                                    <div v-if="errors.phone" class="cart-form__error">{{ errors.phone[0] }}</div>
                                </div>
                            </div>

                            <div class="cart-form__row">
                                <label class="cart-modal__label" for="cart-email">E-mail *</label>
                                <input id="cart-email" v-model="form.email" class="cart-form__input" type="email"
                                    :class="{ 'cart-form__input--error': errors.email }" autocomplete="email">
                                <div v-if="errors.email" class="cart-form__error">{{ errors.email[0] }}</div>
                            </div>

                            <div class="cart-form__row">
                                <label class="cart-modal__label" for="cart-comment">Комментарий к заказу</label>
                                <textarea id="cart-comment" v-model="form.comment" class="cart-form__input"
                                    rows="3"></textarea>
                                <div v-if="errors.comment" class="cart-form__error">{{ errors.comment[0] }}</div>
                            </div>

                            <h2 class="cart-form__title">Способ доставки</h2>

                            <div class="delivery-select">
                                <button class="delivery-select__option" :class="{ 'delivery-select__option--active': delivery?.method === 'pickup_point' }"
                                    type="button" @click="pickupModal = true">
                                    <span class="delivery-select__name">Пункт выдачи</span>
                                    <span v-if="delivery?.method === 'pickup_point'" class="delivery-select__detail">
                                        {{ delivery.city }}, {{ delivery.pickup_point_address }}
                                    </span>
                                    <span v-else class="delivery-select__hint">Выбрать на карте</span>
                                </button>

                                <button class="delivery-select__option" :class="{ 'delivery-select__option--active': delivery?.method === 'courier' }"
                                    type="button" @click="courierModal = true">
                                    <span class="delivery-select__name">Курьер</span>
                                    <span v-if="delivery?.method === 'courier'" class="delivery-select__detail">
                                        {{ delivery.city }}, ул. {{ delivery.street }}, д. {{ delivery.house }}
                                    </span>
                                    <span v-else class="delivery-select__hint">Указать адрес</span>
                                </button>
                            </div>

                            <div v-if="errors.delivery" class="cart-form__error">{{ errors.delivery[0] }}</div>

                            <div class="cart-pay">
                                <p class="cart-pay__text">
                                    После оформления заказа вы будете переведены на страницу безопасной оплаты
                                    и сможете оплатить заказ одним из способов:
                                </p>
                                <div class="cart-pay__icons">
                                    <img v-for="icon in payIcons" :key="icon.src" :src="icon.src" :alt="icon.alt"
                                        class="cart-pay__icon" loading="lazy">
                                </div>
                            </div>

                            <div class="cart-consents">
                                <label class="cart-consents__item">
                                    <input v-model="consents.policy" type="checkbox">
                                    <span>Я согласен с
                                        <a :href="policyUrl" target="_blank">политикой обработки персональных данных</a> *
                                    </span>
                                </label>
                                <label class="cart-consents__item">
                                    <input v-model="consents.consent" type="checkbox">
                                    <span>Я даю
                                        <a :href="consentUrl" target="_blank">согласие на обработку персональных данных</a> *
                                    </span>
                                </label>
                                <div v-if="consentError" class="cart-form__error">{{ consentError }}</div>
                            </div>

                            <div v-if="errors.items" class="cart-form__error">{{ errors.items[0] }}</div>
                            <div v-if="submitError" class="cart-form__error">{{ submitError }}</div>

                            <div class="cart-form__mobile-total">
                                <span>Итого</span>
                                <span>{{ formatPrice(totalSumm) }}</span>
                            </div>

                            <button class="button cart-form__submit" type="submit" :disabled="submitting">
                                <template v-if="submitting">Оформление…</template>
                                <template v-else>Оформить заказ — {{ formatPrice(totalSumm) }}</template>
                            </button>
                        </form>
                    </div>

                    <aside class="cart-page__summary">
                        <div class="cart-summary">
                            <div class="cart-summary__row">
                                <span>Товары ({{ cartStore.count }})</span>
                                <span>{{ formatPrice(cartStore.items_summ) }}</span>
                            </div>
                            <div class="cart-summary__row">
                                <span>Доставка</span>
                                <span>{{ delivery ? formatPrice(delivery.price) : '—' }}</span>
                            </div>
                            <div class="cart-summary__row cart-summary__row--total">
                                <span>Итого</span>
                                <span>{{ formatPrice(totalSumm) }}</span>
                            </div>
                        </div>
                    </aside>
                </div>
            </template>

            <div v-else class="cart-page__empty">
                <p>В корзине пока нет товаров.</p>
                <a class="button" :href="catalogUrl">Перейти в каталог</a>
            </div>
        </div>

        <PickupPointModal v-model="pickupModal" @select="onDeliverySelect" />
        <CourierModal v-model="courierModal" @select="onDeliverySelect" />
    </section>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { cartApi, formatPrice } from '../api';
import { cartStore } from '../store';
import PickupPointModal from './PickupPointModal.vue';
import CourierModal from './CourierModal.vue';

const props = defineProps({
    payIcons: { type: Array, default: () => [] },
    policyUrl: { type: String, required: true },
    consentUrl: { type: String, required: true },
});

const catalogUrl = '/catalog';

const form = reactive({ name: '', phone: '', email: '', comment: '' });
const consents = reactive({ policy: false, consent: false });
const delivery = ref(null);
const errors = ref({});
const consentError = ref('');
const submitError = ref('');
const submitting = ref(false);
const pickupModal = ref(false);
const courierModal = ref(false);

const totalSumm = computed(
    () => cartStore.items_summ + (delivery.value ? Number(delivery.value.price) : 0),
);

onMounted(() => cartStore.load());

async function updateItem(item, quantity) {
    await cartStore.update(item.product_id, item.color, Math.min(Math.max(parseInt(quantity, 10) || 1, 1), 999));
}

async function changeItemColor(item, color) {
    if (color === item.color) {
        return;
    }

    const previousColor = item.color;
    const quantity = item.quantity;

    await cartStore.remove(item.product_id, previousColor);
    await cartStore.add({ product_id: item.product_id, color, quantity });
}

async function removeItem(item) {
    await cartStore.remove(item.product_id, item.color);
}

async function clearCart() {
    await cartStore.clear();
}

function onDeliverySelect(selected) {
    delivery.value = selected;
    errors.value = {};
}

async function submit() {
    errors.value = {};
    consentError.value = '';
    submitError.value = '';

    if (!consents.policy || !consents.consent) {
        consentError.value = 'Необходимо подтвердить согласие с политикой ПД и согласие на обработку ПД.';
        return;
    }

    if (!delivery.value) {
        errors.value = { delivery: ['Выберите способ доставки.'] };
        return;
    }

    submitting.value = true;

    try {
        const result = await cartApi.checkout({
            ...form,
            delivery: delivery.value,
            items: cartStore.items.map((item) => ({
                product_id: item.product_id,
                color: item.color,
                quantity: item.quantity,
            })),
        });

        /*
        |------------------------------------------------------------------
        | ОПЛАТА (YooKassa): после подключения заменить на переход
        | window.location.href = result.payment_url;
        |------------------------------------------------------------------
        */
        window.location.href = `/cart/thanks?order_id=${result.order_id}`;
    } catch (error) {
        if (error.errors && Object.keys(error.errors).length > 0) {
            errors.value = error.errors;
        } else {
            submitError.value = error.message;
        }
    } finally {
        submitting.value = false;
    }
}
</script>

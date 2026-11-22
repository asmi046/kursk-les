<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
            'comment' => ['nullable', 'string', 'max:5000'],

            'delivery' => ['required', 'array'],
            'delivery.method' => ['required', 'string', 'in:pickup_point,courier'],
            'delivery.price' => ['required', 'numeric', 'min:0'],
            'delivery.city' => ['required', 'string', 'max:255'],
            'delivery.pickup_point_id' => ['required_if:delivery.method,pickup_point', 'nullable', 'string', 'max:100'],
            'delivery.pickup_point_address' => ['required_if:delivery.method,pickup_point', 'nullable', 'string', 'max:500'],
            'delivery.street' => ['required_if:delivery.method,courier', 'nullable', 'string', 'max:255'],
            'delivery.house' => ['required_if:delivery.method,courier', 'nullable', 'string', 'max:20'],
            'delivery.apartment' => ['nullable', 'string', 'max:20'],
            'delivery.raw_data' => ['nullable', 'array'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.color' => ['nullable', 'string', 'max:100'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле «ФИО» обязательно для заполнения.',
            'phone.required' => 'Поле «Телефон» обязательно для заполнения.',
            'email.required' => 'Поле «E-mail» обязательно для заполнения.',
            'email.email' => 'Укажите корректный e-mail.',
            'delivery.required' => 'Выберите способ доставки.',
            'delivery.method.required' => 'Способ доставки обязателен.',
            'delivery.method.in' => 'Некорректный способ доставки.',
            'delivery.price.required' => 'Не рассчитана стоимость доставки.',
            'delivery.city.required' => 'Выберите город доставки.',
            'delivery.pickup_point_id.required_if' => 'Выберите пункт выдачи.',
            'delivery.street.required_if' => 'Укажите улицу.',
            'delivery.house.required_if' => 'Укажите номер дома.',
            'items.required' => 'Корзина пуста.',
            'items.min' => 'Корзина пуста.',
            'items.*.product_id.exists' => 'Товар не найден.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'regex:/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
            'policy' => ['accepted'],
            'consent' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.required' => 'Укажите номер телефона.',
            'phone.regex' => 'Введите телефон полностью: +7 (XXX) XXX-XX-XX.',
            'policy.accepted' => 'Необходимо согласие с политикой обработки персональных данных.',
            'consent.accepted' => 'Необходимо согласие на обработку персональных данных.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Проверьте правильность заполнения формы.',
            'errors' => $validator->errors(),
        ], 422));
    }
}

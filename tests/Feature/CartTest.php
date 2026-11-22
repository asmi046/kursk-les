<?php

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Services\CdekService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

function makeProduct(array $attributes = []): Product
{
    return Product::create(array_merge([
        'title' => 'Тестовая доска',
        'description' => 'Описание',
        'slug' => 'test-product-'.uniqid(),
        'price' => 1000,
        'img' => 'test.webp',
        'model' => 'TEST-1',
        'type' => 'Доска',
        'material' => 'Дуб',
        'weight' => '1 кг',
        'colors' => ['Классический', 'Графит'],
    ], $attributes));
}

test('cart add increments positions with different colors', function () {
    $product = makeProduct();

    $this->postJson('/cart/api/add', [
        'product_id' => $product->id,
        'color' => 'Классический',
        'quantity' => 2,
    ])->assertOk()->assertJsonPath('data.count', 2);

    $this->postJson('/cart/api/add', [
        'product_id' => $product->id,
        'color' => 'Графит',
        'quantity' => 1,
    ])->assertOk()->assertJsonPath('data.count', 3);

    $this->postJson('/cart/api/add', [
        'product_id' => $product->id,
        'color' => 'Классический',
    ])->assertOk()->assertJsonPath('data.count', 4);

    $data = $this->getJson('/cart/api')->json('data');

    expect($data['count'])->toBe(4)
        ->and($data['items'])->toHaveCount(2)
        ->and(collect($data['items'])->pluck('color')->all())->toContain('Классический', 'Графит');
});

test('cart rejects color outside product colors', function () {
    $product = makeProduct();

    $this->postJson('/cart/api/add', [
        'product_id' => $product->id,
        'color' => 'Неизвестный цвет',
    ])->assertStatus(422);
});

test('cart update delete and clear work', function () {
    $product = makeProduct();

    $this->postJson('/cart/api/add', ['product_id' => $product->id, 'color' => 'Графит', 'quantity' => 3]);

    $this->postJson('/cart/api/update', [
        'product_id' => $product->id,
        'color' => 'Графит',
        'quantity' => 1,
    ])->assertJsonPath('data.count', 1);

    $this->deleteJson('/cart/api/delete', [
        'product_id' => $product->id,
        'color' => 'Графит',
    ])->assertJsonPath('data.count', 0);

    $this->postJson('/cart/api/add', ['product_id' => $product->id, 'quantity' => 5]);

    $this->deleteJson('/cart/api/clear')->assertJsonPath('data.count', 0);
});

test('checkout creates order with items delivery and clears cart', function () {
    Mail::fake();

    // Регистрация накладной в СДЭК не должна стучаться в API во время теста
    $this->mock(CdekService::class)
        ->shouldReceive('registerOrder')
        ->andReturn(null);

    $product = makeProduct();

    $this->postJson('/cart/api/add', [
        'product_id' => $product->id,
        'color' => 'Классический',
        'quantity' => 2,
    ]);

    $response = $this->postJson('/cart/api/checkout', [
        'name' => 'Иван Иванов',
        'phone' => '+7 900 000-00-00',
        'email' => 'ivan@example.com',
        'comment' => 'Комментарий',
        'delivery' => [
            'method' => 'pickup_point',
            'price' => 350,
            'city' => 'Москва',
            'pickup_point_id' => 'MSK123',
            'pickup_point_address' => 'ул. Тверская, 1',
            'raw_data' => [
                'tariff' => ['tariff_code' => 136, 'tariff_name' => 'Посылка склад-дверь'],
            ],
        ],
        'items' => [
            ['product_id' => $product->id, 'color' => 'Классический', 'quantity' => 2],
        ],
    ]);

    $response->assertOk()->assertJsonPath('data.total_summ', 2350);

    $order = Order::with('items', 'delivery')->sole();

    expect((string) $order->items_summ)->toBe('2000.00')
        ->and((string) $order->delivery_price)->toBe('350.00')
        ->and((string) $order->total_summ)->toBe('2350.00')
        ->and($order->items)->toHaveCount(1)
        ->and($order->items->first()->color)->toBe('Классический')
        ->and($order->delivery->provider)->toBe('cdek')
        ->and($order->delivery->method)->toBe('pickup_point')
        ->and($order->delivery->pickup_point_id)->toBe('MSK123');

    $this->getJson('/cart/api')->assertJsonPath('data.count', 0);

    Mail::assertNothingQueued();
});

test('checkout validation requires contacts delivery and items', function () {
    makeProduct();

    $this->postJson('/cart/api/checkout', [])->assertStatus(422);
});

test('checkout dispatches order created event', function () {
    Event::fake();

    $product = makeProduct();

    $this->postJson('/cart/api/add', ['product_id' => $product->id, 'quantity' => 1]);

    $this->postJson('/cart/api/checkout', [
        'name' => 'Иван Иванов',
        'phone' => '+7 900 000-00-00',
        'email' => 'ivan@example.com',
        'delivery' => [
            'method' => 'courier',
            'price' => 500,
            'city' => 'Москва',
            'street' => 'Тверская',
            'house' => '1',
            'raw_data' => ['tariff' => ['tariff_code' => 137]],
        ],
        'items' => [
            ['product_id' => $product->id, 'quantity' => 1],
        ],
    ])->assertOk();

    Event::assertDispatched(OrderCreated::class);
});

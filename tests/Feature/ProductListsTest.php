<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('favorites page returns successful response', function () {
    $this->get(route('favorites.index'))->assertOk();
});

test('compare page returns successful response', function () {
    $this->get(route('compare.index'))->assertOk();
});

test('favorite toggle adds and removes product', function () {
    $product = makeProduct();

    $this->postJson(route('favorites.api.toggle'), ['product_id' => $product->id])
        ->assertOk()
        ->assertJsonPath('data.added', true)
        ->assertJsonPath('data.count', 1);

    $this->postJson(route('favorites.api.toggle'), ['product_id' => $product->id])
        ->assertOk()
        ->assertJsonPath('data.added', false)
        ->assertJsonPath('data.count', 0);
});

test('compare holds no more than 4 products', function () {
    $products = collect(range(1, 5))->map(fn (int $i) => makeProduct(['slug' => 'cmp-'.$i]));

    foreach ($products as $product) {
        $this->postJson(route('compare.api.toggle'), ['product_id' => $product->id])->assertOk();
    }

    $response = $this->getJson(route('compare.api.index'))->assertOk();

    $response->assertJsonPath('data.count', 4);
    expect($response->json('data.ids'))->not->toContain($products->last()->id);
});

test('compare remove deletes product from list', function () {
    $product = makeProduct(['slug' => 'cmp-del']);

    $this->postJson(route('compare.api.toggle'), ['product_id' => $product->id])->assertOk();

    $this->deleteJson(route('compare.api.delete'), ['product_id' => $product->id])
        ->assertOk()
        ->assertJsonPath('data.count', 0);
});

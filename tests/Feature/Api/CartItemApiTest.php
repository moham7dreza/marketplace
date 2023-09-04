<?php

use App\Models\Product;

it('add item to cart', function () {
    $product = Product::factory()->create();
    $data = [
        'number' => fake()->numberBetween(0, 5),
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . auth()->user()->getRememberToken(),
        'Accept' => 'application/json',
    ])
        ->postJson("/api/v1/cart-items/store/{$product->id}", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'item added successfully']);
});

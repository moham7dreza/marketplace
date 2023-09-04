<?php

use App\Models\Product;
use App\Services\ShareService;

it('add item to cart', function () {
    $product = Product::factory()->create();
    $data = [
        'number' => fake()->numberBetween(1, 5),
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::brear_token,
        'Accept' => 'application/json',
    ])
        ->postJson("/api/v1/cart-items/store/{$product->id}", $data);
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'item added successfully']);
});

<?php

use App\Models\Product;
use App\Models\User;

it('add item to cart', function () {
    $product = Product::factory()->create();
    $data = [
        'number' => fake()->numberBetween(1, 5),
    ];
    app()->get('auth')->forgetGuards();
    $response = $this
        ->actingAs(User::first())
//        ->withHeaders([
//        'Authorization' => 'Bearer ' . ShareService::findOrCreateToken(),
//        'Accept' => 'application/json',
//    ])
        ->postJson("/api/v1/cart-items/store/{$product->id}", $data);

    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'item added successfully']);
});

<?php

use App\Models\Product;

it('add product', function () {
    $data = [
        'title' => 'product title',
        'price' => 9999.999,
    ];
    $response = $this->postJson("/api/v1/products/store", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'product created successfully']);
});

it('search products', function () {
    $data = [
        'key' => fake()->jobTitle,
    ];
    $response = $this->getJson("/api/v1/products/search", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'search in products']);
});

it('destroy product', function () {
    $product = Product::factory()->create();
    $response = $this->deleteJson("/api/v1/products/destroy/{$product->id}");
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'product destroyed successfully']);
});

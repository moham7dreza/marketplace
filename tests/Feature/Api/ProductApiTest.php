<?php

use App\Enums\SortEnum;
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

it('filter products', function () {
    $data = [
        'sort' => SortEnum::random(),
        'search' => fake()->jobTitle,
        'min_price' => fake()->numberBetween(1000, 9999),
        'max_price' => fake()->numberBetween(10000, 99999),
    ];
    $response = $this->getJson("/api/v1/products/filter", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'filter in products']);
});

it('destroy product', function () {
    $product = Product::factory()->create();
    $response = $this->deleteJson("/api/v1/products/destroy/{$product->id}");
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'product destroyed successfully']);
});

<?php

use App\Enums\SortEnum;
use App\Models\Product;
use App\Services\ShareService;

it('add product', function () {
    $data = [
        'title' => 'product title',
        'price' => 9999.999,
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::findOrCreateToken(),
        'Accept' => 'application/json',
    ])->postJson("/api/v1/products/store", $data);
    //print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'product created successfully']);
});

it('products index', function () {
    $data = [
        'sort' => SortEnum::random()->value,
        'search' => fake()->jobTitle,
        'min_price' => fake()->numberBetween(1000, 9999),
        'max_price' => fake()->numberBetween(10000, 99999),
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::findOrCreateToken(),
        'Accept' => 'application/json',
    ])->getJson("/api/v1/products/index", $data);
    //print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'products index']);
});

it('destroy product', function () {
    $product = Product::factory()->create();
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::findOrCreateToken(),
        'Accept' => 'application/json',
    ])->deleteJson("/api/v1/products/destroy/{$product->id}");
    //print_head($response);
    $response->assertStatus(201)->assertJson([
        'status' => 'success',
//        'message' => 'product destroyed successfully',
        'message' => 'you can not delete this product',
    ]);
});

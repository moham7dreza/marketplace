<?php

use App\Models\Product;
use App\Services\ShareService;

it('image upload', function () {
    $product = Product::factory()->create();
    $data = [
        'image' => '',
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::brear_token,
        'Accept' => 'application/json',
    ])->postJson("/api/v1/images/store/{$product->id}", $data);
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'image created successfully']);
});

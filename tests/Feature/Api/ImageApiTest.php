<?php

use App\Models\Product;
use App\Services\ShareService;
use Illuminate\Http\Testing\File;

it('image upload', function () {
    $product = Product::factory()->create();
    $data = [
        'image' => File::image('image.png'),
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::brear_token,
        'Accept' => 'application/json',
    ])->postJson("/api/v1/images/store/{$product->id}", $data);
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'image created successfully']);
});

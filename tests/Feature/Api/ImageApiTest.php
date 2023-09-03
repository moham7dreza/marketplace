<?php

use App\Models\Product;
use Illuminate\Http\UploadedFile;

it('image upload', function () {
    $product = Product::factory()->create();
    $data = [
        'image' => UploadedFile::fake()->create('dasdad.png'),
    ];
    $response = $this->postJson("/api/v1/images/store/{$product->id}", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'image created successfully']);
});

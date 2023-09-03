<?php

use App\Models\Delivery;

it('order create', function () {
    $data = [
        'delivery_id' => Delivery::factory()->create()->id,
    ];
    $response = $this->postJson("/api/v1/orders/store", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'order created successfully']);
});

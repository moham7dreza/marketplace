<?php

use App\Models\Delivery;
use App\Services\ShareService;

it('order create', function () {
    $data = [
        'delivery_id' => Delivery::factory()->create()->id,
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::brear_token,
        'Accept' => 'application/json',
    ])->postJson("/api/v1/orders/store", $data);
    print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'order created successfully']);
});

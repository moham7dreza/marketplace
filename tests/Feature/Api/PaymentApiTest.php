<?php

use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentTypeEnum;

it('submit payment', function () {
    $data = [
        'type' => PaymentTypeEnum::random(),
        'gateway' => PaymentGatewayEnum::random(),
    ];
    $response = $this->postJson("/api/v1/payments/store", $data);
    dump($response);
    $response->assertStatus(201)->assertJson(['status' => 'payment submitted successfully']);
});

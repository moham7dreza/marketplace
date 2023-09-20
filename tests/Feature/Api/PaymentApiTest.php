<?php

use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentTypeEnum;
use App\Services\ShareService;
use Illuminate\Support\Facades\Mail;

it('submit payment', function () {
    Mail::fake();
    $data = [
        'type' => PaymentTypeEnum::random(),
        'gateway' => PaymentGatewayEnum::random(),
    ];
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . ShareService::findOrCreateToken(),
        'Accept' => 'application/json',
    ])->postJson("/api/v1/payments/store", $data);
    //print_head($response);
    $response->assertStatus(201)->assertJson(['status' => 'success', 'message' => 'payment submitted successfully']);
});

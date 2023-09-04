<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PaymentService
{
    public function store($request, $order): Model|Builder
    {
        return $this->query()->create([
            'user_id' => auth()->id(),
            'amount' => $order->amount ?? 0,
            'status' => PaymentStatusEnum::not_paid->value,
            'type' => $request->type,
            'gateway' => $request->gateway,
        ]);
    }

    private function query(): Builder
    {
        return Payment::query();
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentApiController extends Controller
{
    private PaymentService $service;
    private OrderService $orderService;

    public function __construct(PaymentService $service, OrderService $orderService)
    {
        $this->service = $service;

        $this->orderService = $orderService;
    }

    public function store(PaymentRequest $request): JsonResponse
    {
        $order = $this->orderService->findUserUncheckedOrder();
        $payment = $this->service->store($request, $order);
        $order->update([
            'status' => OrderStatusEnum::confirmed->value,
            'payment_id' => $payment->id,
        ]);

        if ($request->gateway == PaymentGatewayEnum::zarin_pal->value && $request->type == PaymentTypeEnum::online->value) {
            // goto gateway
        }

        $payment->update([
            'status' => PaymentStatusEnum::paid->value,
            'pay_at' => now(),
        ]);

        $this->orderService->addOrderItemsAndDeleteCartItems($order);

        return response()->json([
            'status' => 'success',
            'message' => 'payment submitted successfully',
            'data' => [
                'order' => new OrderResource($order),
                'payment' => new PaymentResource($order),
            ],
        ], 201);
    }
}

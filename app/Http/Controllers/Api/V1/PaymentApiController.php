<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Events\SendEmailEvent;
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

        $this->sendEmailToAdmin($payment);

        return response()->json([
            'status' => 'success',
            'message' => 'payment submitted successfully',
            'data' => [
                'order' => new OrderResource($order),
                'payment' => new PaymentResource($order),
            ],
        ], 201);
    }


    public function sendEmailToAdmin($payment): void
    {
        $body = 'new order submitted';
        $subject = $payment->user->name . ' submitted new order with amount of ' . $payment->amount . ', which state of payment is ' . $payment->status->value . ' and pay time is ' . $payment->pay_at;

        event(new SendEmailEvent(subject: $subject, body: $body));
    }
}

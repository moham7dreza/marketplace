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
use App\Models\Delivery;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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


    /**
     * @OA\Post(
     ** path="/api/v1/payments/store",
     *  tags={"Payment Module"},
     *   security={{"sanctum":{}}},
     *  description="store user payment",
     * @OA\RequestBody(
     *    required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *          @OA\Property(
     *                   property="type",
     *                   description="enter payment type",
     *                   type="string",
     *            ),@OA\Property(
     *                   property="gateway",
     *                   description="enter payment gateway",
     *                   type="string",
     *            ),
     *       )
     * )
     * ),
     *   @OA\Response(
     *      response=200,
     *      description="Data saved",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     *
     */
    public function store(PaymentRequest $request): JsonResponse
    {
        $order = $this->orderService->findUserUncheckedOrder();
        if (!$order) {
            $order = $this->createTestOrder();
        }
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
        $subject = 'new order submitted';
        $body = $payment->user->name . ' submitted new order with amount of ' . number_format($payment->amount) . ', which state of payment is ' . PaymentStatusEnum::from($payment->status->value)->name . ' and pay time is ' . $payment->pay_at;

        event(new SendEmailEvent(subject: $subject, body: $body));
    }

    /**
     * @return Order|Collection|Model
     */
    public function createTestOrder(): Order|Collection|Model
    {
        return Order::factory()->create([
            'user_id' => auth()->id(),
            'delivery_id' => Delivery::factory()->create()->id,
            'status' => OrderStatusEnum::unchecked->value,
        ]);
    }
}

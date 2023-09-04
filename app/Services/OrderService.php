<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'user_id' => auth()->id(),
            'status' => OrderStatusEnum::unchecked->value,
            'delivery_id' => $request->delivery_id,
        ]);
    }

    public function addOrderItemsAndDeleteCartItems($order): void
    {
        // add cart items to order items and delete them
        foreach (auth()->user()->cartItems as $item) {
            $product = $item->product;
            // number * product price
            $amount = $product->price * $item->number;
            if ($order->delivery_id) {
                // additional delivery amount for every item
                $deliveryAmount = $item->delivery ? $item->delivery->amount : 0;
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'amount' => $amount,
                    'number' => $item->number,
                    'delivery_amount' => $deliveryAmount,
                    'final_amount' => $amount + $deliveryAmount
                ]);
            } else {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'amount' => $amount,
                    'number' => $item->number,
                    'final_amount' => $amount,
                ]);
            }
            $item->delete();
        }
    }

    public function findUserUncheckedOrder(): Model|Builder|null
    {
        return $this->query()->where([
            'user_id' => auth()->id(),
            'status' => OrderStatusEnum::unchecked->value,
        ])->first();
    }

    private function query(): Builder
    {
        return Order::query();
    }
}

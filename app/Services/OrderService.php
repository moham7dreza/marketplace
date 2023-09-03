<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function store($request): Model|Builder
    {
        return DB::transaction(function () use ($request) {
            $order = $this->query()->create([
                'user_id' => auth()->id(),
                'status' => OrderStatusEnum::unchecked->value,
                'delivery_id' => $request->delivery_id,
            ]);

            // add cart items to order items and delete them
            foreach (auth()->user()->cartItems as $item) {
                $product = $item->product;
                // number * product price
                $amount = $product->price * $item->number;
                if ($request->delivery_id) {
                    // additional delivery amount for every item
                    $amount += $product->delivery->amount;
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'amount' => $amount,
                        'number' => $item->number
                    ]);
                }
                $item->delete();
            }
        });
    }

    private function query(): Builder
    {
        return Order::query();
    }
}

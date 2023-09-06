<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{

    protected $model = OrderItem::class;

    public function definition(): array
    {
        dump('Run OrderItem Factory ...');
        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'number' => $this->faker->numberBetween(0, 100),
            'amount' => $this->faker->randomFloat(3, 1000, 9999),
            'delivery_amount' => $this->faker->randomFloat(3, 1000, 9999),
            'final_amount' => $this->faker->randomFloat(3, 1000, 9999),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\ItemDelivery;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemDeliveryFactory extends Factory
{

    protected $model = ItemDelivery::class;

    public function definition(): array
    {
        dump('Run ItemDelivery Factory ...');
        return [
            'product_id' => Product::factory(),
            'delivery_id' => Delivery::factory(),
            'amount' => $this->faker->randomFloat(),
        ];
    }
}

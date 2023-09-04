<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{

    protected $model = CartItem::class;

    public function definition(): array
    {
        dump('Run CartItem Factory ...');
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'number' => $this->faker->numberBetween(0, 100),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    protected $model = Product::class;

    public function definition(): array
    {
        dump('Run Product Factory ...');
        return [
            'title' => $this->faker->title,
            'price' => $this->faker->randomFloat(),
            'user_id' => User::factory(),
            'approved' => $this->faker->boolean,
        ];
    }
}

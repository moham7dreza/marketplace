<?php

namespace Database\Factories;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{

    protected $model = Delivery::class;

    public function definition(): array
    {
        dump('Run Delivery Factory ...');
        return [
            'title' => $this->faker->jobTitle,
            'delivery_time' => $this->faker->numberBetween(1, 31)
        ];
    }
}

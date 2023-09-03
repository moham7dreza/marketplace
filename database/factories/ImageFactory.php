<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{

    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'image' => $this->faker->image
        ];
    }
}

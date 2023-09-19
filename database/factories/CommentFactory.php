<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{

    protected $model = Comment::class;

    public function definition(): array
    {
        //dump('Run Comment Factory ...');
        return [
            'body' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'parent_id' => $this->faker->boolean ? Comment::factory() : null,
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'seen' => $this->faker->boolean,
            'approved' => $this->faker->boolean,
        ];
    }
}

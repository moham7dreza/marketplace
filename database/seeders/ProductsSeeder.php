<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Delivery;
use App\Models\Image;
use App\Models\ItemDelivery;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Delivery::factory(5)->create();

        Product::factory(10)
            ->has(Image::factory(5))
            ->has(Comment::factory(5))
            ->has(ItemDelivery::factory(5), 'delivery')
            ->create();
    }
}

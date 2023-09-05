<?php

namespace Database\Seeders;

use App\Models\Comment;
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
        Product::factory(2)
            ->has(Image::factory(2))
            ->has(Comment::factory(2))
            ->has(ItemDelivery::factory(), 'delivery')
            ->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Order::factory(5)
                ->has(OrderItem::factory(5))
            )
            ->has(Payment::factory(5))
            ->has(Comment::factory(5))
            ->has(CartItem::factory(5))
            ->create();
    }
}

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
        User::factory(2)
            ->has(Order::factory(2)
                ->has(OrderItem::factory(2), 'items')
            )
            ->has(Payment::factory(2))
            ->has(Comment::factory(2))
            ->has(CartItem::factory(2))
            ->create();
    }
}

<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    public function store($request): Model|Builder
    {
        return $this->query()->create([

        ]);
    }

    private function query(): Builder
    {
        return Order::query();
    }
}

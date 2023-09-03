<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CartItemService
{
    public function store($request, $model): Model|Builder
    {
        return $this->query()->create([
            'user_id' => auth()->id(),
            'product_id' => $model->id,
            'number' => $request->number,
        ]);
    }

    private function query(): Builder
    {
        return CartItem::query();
    }
}

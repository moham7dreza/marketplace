<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductService
{
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'title' => $request->title,
            'price' => $request->price,
            'user_id' => auth()->id() ?? 1,
            'approved' => StatusEnum::inactive->value,
        ]);
    }

    public function search($key): Builder
    {
        return $this->query()->where('title', 'like', "%{$key}%");
    }

    private function query(): Builder
    {
        return Product::query();
    }
}

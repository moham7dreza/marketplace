<?php

namespace App\Services;

use App\Enums\SortEnum;
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

    public function filter($request, $items = null)
    {
        if (!$items) {
            $items = $this->query();
        }
        $items = $this->getItems($request, $items);

        return $items
            // when search for key
            ->when($request->search, function ($items) use ($request) {
                $items->where('title', 'like', "%{$request->search}%");
            })
            ->when($request->min_price, function ($items) use ($request) {
                $items->where('price', '>=', $request->min_price);
            })
            ->when($request->max_price, function ($items) use ($request) {
                $items->where('price', '<=', $request->max_price);
            });
    }

    private function query(): Builder
    {
        return Product::query();
    }

    /**
     * @param $request
     * @param mixed $items
     * @return mixed
     */
    public function getItems($request, mixed $items): mixed
    {
//switch for set sort for filtering
        return match ($request->sort) {
            SortEnum::most_expensive->value => $items->orderBy('price', 'desc'),
            SortEnum::latest->value => $items->latest(),
            SortEnum::cheapest->value => $items->orderBy('price'),
            SortEnum::oldest->value => $items->oldest(),
            SortEnum::fastest_delivery->value => $items->whereHas('delivery', function (Builder $builder) {
                $builder->orderBy('delivery_time', 'desc');
            }),
            default => $items->orderBy('created_at'),
        };
    }
}

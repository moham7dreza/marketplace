<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImageService
{
    public function store($request, $model): Model|Builder|string
    {
        $imageService = resolve(\App\Services\Image\ImageService::class);
        if ($request->hasFile('image')) {
            $result = ShareService::createIndexAndSaveImage('products', $request->file('image'), $imageService);
            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        }

        return $this->query()->create([
            'product_id' => $model->id,
            'image' => $request->image,
        ]);
    }

    private function query(): Builder
    {
        return Image::query();
    }
}

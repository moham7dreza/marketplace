<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Comment;

class CommentService
{
    public function store($request, $model): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->query()->create([
            'body' => ShareService::replaceNewLineWithTag($request->body),
            'user_id' => auth()->id() ?? 1,
            'product_id' => $model->id,
            'seen' => StatusEnum::inactive->value,
            'approved' => StatusEnum::inactive->value,
        ]);
    }

    private function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Comment::query();
    }

    public function reply($request, $comment): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->query()->create([
            'body' => ShareService::replaceNewLineWithTag($request->body),
            'user_id' => auth()->id() ?? 1,
            'product_id' => $comment->product_id,
            'parent_id' => $comment->id,
            'seen' => StatusEnum::inactive->value,
            'approved' => StatusEnum::inactive->value,
        ]);
    }
}

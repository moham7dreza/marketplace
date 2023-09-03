<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'body' => $this->body,
            'parent' => $this->parent ? new CommentResource($this->parent) : null,
            'answers_count' => $this->answers()->count(),
            'answers' => CommentResource::collection($this->answers)->response()->getData(true),
            'approved' => $this->approved,
            'seen' => $this->seen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

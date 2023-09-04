<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
//            'comments' => CommentResource::collection($this->comments)->response()->getData(true),
//            'products' => ProductResource::collection($this->products)->response()->getData(true),
//            'orders' => OrderResource::collection($this->orders)->response()->getData(true),
//            'payments' => PaymentResource::collection($this->payments)->response()->getData(true),
//            'cartItems' => CartItemResource::collection($this->cartItems)->response()->getData(true),
        ];
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItemRequest;
use App\Models\Product;

class OrderItemApiController extends Controller
{
    public function store(OrderItemRequest $request, Product $product)
    {

    }
}

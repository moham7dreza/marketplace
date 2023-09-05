<?php

namespace App\Console\Commands;

use App\Models\ItemDelivery;
use App\Models\Product;
use App\Services\ShareService;
use Illuminate\Console\Command;

class SubmitOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:submit-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $product = Product::factory()->create();
//        $addProductToCart = ShareService::sendInternalApiRequestAndGetResponse(params: ['number' => 3], url: "/api/v1/cart-items/store/{$product->id}", method: 'post');
        $delivery = ItemDelivery::factory()->create();
        $submitInitialOrder = ShareService::sendInternalApiRequestAndGetResponse(params: ['delivery_id' => $delivery->delivery_id], url: "/api/v1/orders/store", method: 'post');

        dd($submitInitialOrder);
    }
}

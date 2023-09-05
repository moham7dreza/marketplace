<?php

namespace App\Console\Commands;

use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentTypeEnum;
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
        $data = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
        ];
        $user = ShareService::sendInternalApiRequestAndGetResponse(setAuthHeaders: false, route: 'api.v1.register', params: $data, method: 'post');
        dd($user);
        // add item to cart
        $product = Product::factory()->create();
        $data = ['number' => 3];
//        $addProductToCart = ShareService::sendInternalApiRequestAndGetResponse(params: $data, url: "/api/v1/cart-items/store/{$product->id}", method: 'post');

        // submit initial order
        $delivery = ItemDelivery::factory()->create();
        $data = ['delivery_id' => $delivery->delivery_id];
        $submitInitialOrder = ShareService::sendInternalApiRequestAndGetResponse(route: 'api.v1.orders.store', params: $data, method: 'post');

        // pay section
        $data = ['type' => PaymentTypeEnum::online->value, 'gateway' => PaymentGatewayEnum::zarin_pal->value];
        $submitInitialOrder = ShareService::sendInternalApiRequestAndGetResponse(route: 'api.v1.payments.store', params: $data, method: 'post');
    }
}

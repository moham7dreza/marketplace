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
        //******************************** register user and retrieve token

        $data = [
            'name' => 'admin',
            'email' => fake()->unique()->email,
            'password' => 'admin',
        ];
        $registerUser = ShareService::sendHttpPostRequest('/api/v1/register', $data);

        $token = $registerUser->data->token;

        //******************************** add item to cart

        $product = Product::factory()->create();

        $data = ['number' => 3];

        $cartItem = ShareService::sendHttpPostRequestWithAuth("/api/v1/cart-items/store/{$product->id}", $data, $token);
        dump($cartItem);

        //******************************** submit initial order for user

        // if select a delivery method for shipping product
        $delivery = ItemDelivery::factory()->create();

        $data = ['delivery_id' => $delivery->delivery_id];

        $order = ShareService::sendHttpPostRequestWithAuth("/api/v1/orders/store", $data, $token);
        dump($order);
        //******************************** pay user submitted order

        $data = ['type' => PaymentTypeEnum::online->value, 'gateway' => PaymentGatewayEnum::zarin_pal->value];

        $payment = ShareService::sendHttpPostRequestWithAuth("/api/v1/payments/store", $data, $token);
        dump($payment);

        dump('Finish');
    }
}

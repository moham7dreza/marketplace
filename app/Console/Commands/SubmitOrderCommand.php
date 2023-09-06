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
    protected $description = 'order submit process';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //******************************** register user and retrieve token

        $token = $this->getToken();

        //******************************** add item to cart

        $cartItem = $this->addItemToCart($token);

        //******************************** submit initial order for user

        $order = $this->submitOrder($token);

        //******************************** pay user submitted order

        $this->payment($token);

        dump('Finish');
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        $data = [
            'name' => 'admin',
            'email' => fake()->unique()->email,
            'password' => 'admin',
        ];
        $registerUser = ShareService::sendHttpPostRequest('/api/v1/register', $data);

        return $registerUser->data->token;
    }

    /**
     * @param string $token
     * @return string
     */
    public function addItemToCart(string $token): mixed
    {
        $product = Product::factory()->create();

        $data = ['number' => 3];

        $cartItem = ShareService::sendHttpPostRequestWithAuth("/api/v1/cart-items/store/{$product->id}", $data, $token);
        dump($cartItem);
        return $cartItem;
    }

    /**
     * @param string $token
     * @return array
     */
    public function submitOrder(string $token): mixed
    {
        // if select a delivery method for shipping product
        $delivery = ItemDelivery::factory()->create();

        $data = ['delivery_id' => $delivery->delivery_id];

        $order = ShareService::sendHttpPostRequestWithAuth("/api/v1/orders/store", $data, $token);
        dump($order);
        return $order;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function payment(string $token): mixed
    {
        $data = ['type' => PaymentTypeEnum::online->value, 'gateway' => PaymentGatewayEnum::zarin_pal->value];

        $payment = ShareService::sendHttpPostRequestWithAuth("/api/v1/payments/store", $data, $token);
        dump($payment);

        return $payment;
    }
}

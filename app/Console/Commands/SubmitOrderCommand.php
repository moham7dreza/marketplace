<?php

namespace App\Console\Commands;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Models\ItemDelivery;
use App\Models\Order;
use App\Models\Product;
use App\Services\ShareService;
use Carbon\Carbon;
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

        ShareService::findOrCreateToken(newUser: true);

        //******************************** add item to cart

        $this->addItemToCart();

        //******************************** submit initial order for user

        $order = $this->submitOrder();

        //******************************** pay user submitted order

        $this->payment();

        //******************************** total report

//        $this->report($order->data->id);

        //dump('Finish');
    }

    /**
     * @return string
     */
    public function addItemToCart(): mixed
    {
        $product = Product::factory()->create();

        $data = ['number' => 3];

        $cartItem = ShareService::sendHttpPostRequestWithAuth("/api/v1/cart-items/store/{$product->id}", $data);
        //dump($cartItem);
        return $cartItem;
    }

    /**
     * @return array
     */
    public function submitOrder(): mixed
    {
        // if select a delivery method for shipping product
        $delivery = ItemDelivery::factory()->create();

        $data = ['delivery_id' => $delivery->delivery_id];

        $order = ShareService::sendHttpPostRequestWithAuth("/api/v1/orders/store", $data);
        //dump($order);
        return $order;
    }

    /**
     * @return mixed
     */
    public function payment(): mixed
    {
        $data = ['type' => PaymentTypeEnum::online->value, 'gateway' => PaymentGatewayEnum::zarin_pal->value];

        $payment = ShareService::sendHttpPostRequestWithAuth("/api/v1/payments/store", $data);
        //dump($payment);

        return $payment;
    }

    private function report($order_id): void
    {
        dump('************************************ Total report');
        $order = Order::query()->findOrFail($order_id);
        $payment = $order->payment;
        dump('Payment amount is : ' . number_format($payment->amount));
        dump('Payment pay time : ' . Carbon::parse($payment->pay_at)->format('Y-m-d h:i:s'));
        dump('Payment status is : ' . PaymentStatusEnum::from($payment->status->value)->name);
        dump('Payment type is : ' . PaymentTypeEnum::from($payment->type->value)->name);
        dump('Payment gateway is : ' . PaymentGatewayEnum::from($payment->gateway->value)->name);
        dump('Order status is : ' . OrderStatusEnum::from($order->status->value)->name);
        dump('Order items count : ' . $order->items->count());
        dump('Order with delivery method : ' . ($order->delivery_id ? 'Yes' : 'No'));
        dump('See you later ...');
        dump('*************************************************************');
    }
}

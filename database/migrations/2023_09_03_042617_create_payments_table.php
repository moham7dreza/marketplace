<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 20, 3);
            $table->foreignId('user_id')->index();
            $table->tinyInteger('status')->unsigned();//PaymentStatusEnum
            $table->tinyInteger('type')->unsigned();//PaymentTypeEnum
            $table->tinyInteger('gateway')->unsigned()->nullable();//PaymentGatewayEnum
            $table->timestamp('pay_at')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('details')->nullable();
            $table->index(['status', 'type', 'gateway']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

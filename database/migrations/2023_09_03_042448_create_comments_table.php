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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('product_id')->index();
            $table->foreignId('parent_id')->nullable();
            $table->text('body');
            $table->tinyInteger('seen')->unsigned();// StatusEnum
            $table->tinyInteger('approved')->unsigned();// StatusEnum
            $table->index(['seen', 'approved']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

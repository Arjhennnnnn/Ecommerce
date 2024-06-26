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
        Schema::create('shop_orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->constrained('users');

            $table->date('order_date');

            $table->unsignedBigInteger('payment_method_id')->nullable();

            $table->foreignId('shipping_address')->constrained('user_address');

            $table->foreignId('shipping_method')->constrained('shipping_methods');

            $table->float('order_total')->nullable();

            $table->foreignId('order_status')->constrained('order_status');

            $table->timestamps();

            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_orders');
    }
};

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
        Schema::create('order_lines', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_item_id')->constrained('product_items');

            $table->foreignId('order_id')->constrained('shop_orders');

            $table->integer('quantity')->nullable();

            $table->float('price')->nullable();

            $table->timestamps();

            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};

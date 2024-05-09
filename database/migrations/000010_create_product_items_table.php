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
        Schema::create('product_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')->constrained('products');

            $table->string('sku')->nullable();

            $table->integer('qty_in_stock')->nullable();

            $table->string('product_image')->nullable();

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
        Schema::dropIfExists('product_items');
    }
};

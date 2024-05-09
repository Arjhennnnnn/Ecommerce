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
        Schema::create('user_reviews', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->constrained('users');

            $table->foreignId('ordered_product_id')->constrained('order_lines');

            $table->string('rating_value')->nullable();

            $table->string('comment')->nullable();

            $table->timestamps();
            
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reviews');
    }
};

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
        Schema::create('address', function (Blueprint $table) {

            $table->id();

            $table->string('unit_number')->nullable();

            $table->string('street_number')->nullable();

            $table->string('address_line1')->nullable();

            $table->string('address_line2')->nullable();

            $table->string('city')->nullable();

            $table->string('region')->nullable();

            $table->string('postal_code')->nullable();

            $table->foreignId('country_id')->constrained('countries');
            
            $table->timestamps();
            
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};

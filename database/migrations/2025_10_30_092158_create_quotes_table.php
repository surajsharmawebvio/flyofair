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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('trip_type'); // oneway, round, multi
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('traveler_info');
            $table->string('from_location');
            $table->string('to_location');
            $table->date('departure_date');
            $table->date('return_date')->nullable(); // Only for round trips
            $table->json('multi_city_details')->nullable(); // For multi-city trips
            $table->string('status')->default('pending'); // pending, processed, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};

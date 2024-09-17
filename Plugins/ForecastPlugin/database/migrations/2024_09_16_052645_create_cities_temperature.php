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
        Schema::create('cities_temperature', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('city_id')->references('id')->on('cities'); ;
            $table->string('temperature');
            $table->string('time_12_hour')->nullable();
            $table->string('time_24_hour')->nullable();
            $table->integer('time_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities_temperature');
    }
};

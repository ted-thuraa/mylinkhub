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
        Schema::create('pageviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->string('ip', 45)->nullable();
            $table->string('referrer')->nullable();
            $table->string('country', 45)->nullable();
            $table->string('countryCode')->nullable();
            $table->string('cityName')->nullable();
            $table->string('areaCode')->nullable();
            $table->string('regionName')->nullable();
            $table->string('regionCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pageviews');
    }
};

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description', 500)->nullable();
            $table->string('status')->default('Active')->nullable();
            $table->string('plan_type')->default('subscription')->nullable();
            $table->string('monthlyPriceId')->nullable();
            $table->string('yearlyPriceId')->nullable();
            $table->string('lifeTimepriceId')->nullable();
            $table->float('monthlyprice')->nullable();
            $table->float('yearlyprice')->nullable();
            $table->float('lifeTimeprice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

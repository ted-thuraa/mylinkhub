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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
          
            $table->unsignedInteger('sub_id');
            $table->unsignedInteger('order_id');
            $table->string('sub_status');
            $table->unsignedInteger('customer_id')->nullable();
            $table->string('user_email')->nullable();
            $table->string('checkout_email')->nullable();
            $table->string('planname', 45);
            
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

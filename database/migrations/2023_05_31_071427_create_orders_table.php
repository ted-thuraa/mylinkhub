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
        Schema::create('orders', function (Blueprint $table) {
            
            $table->id();
<<<<<<< HEAD
=======
            $table->uuid('user_id');
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            $table->string('order_id');
            $table->unsignedInteger('orderitem_id');
            $table->string('order_status');
            $table->unsignedInteger('customer_id');
            $table->string('user_email')->nullable();
            $table->string('checkout_email');
            $table->string('planname')->nullable();
            $table->unsignedInteger('total_price');
            $table->string('total_formatted');
            $table->unsignedInteger('product_id')->nullable();

            //$table->foreignIdFor(\App\Models\User::class, 'user_id');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

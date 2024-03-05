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
        Schema::create('paying_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->unsignedBigInteger('lemoncustomer_id');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('product_name')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->timestamp('sub_ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paying_customers');
    }
};

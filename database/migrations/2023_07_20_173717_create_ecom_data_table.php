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
        Schema::create('ecom_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_id');
            $table->foreign('link_id')
                ->references('id')
                ->on('links')
                ->onDelete('cascade');
            $table->text('ctabtntext');   
            $table->text('item1_name')->nullable();
            $table->text('item1_desc')->nullable();
            $table->text('item1_price')->nullable();
            $table->text('item1_image')->nullable();

            $table->text('item2_name')->nullable();
            $table->text('item2_desc')->nullable();
            $table->text('item2_price')->nullable();
            $table->text('item2_image')->nullable();

            $table->text('item3_name')->nullable();
            $table->text('item3_desc')->nullable();
            $table->text('item3_price')->nullable();
            $table->text('item3_image')->nullable();

            $table->text('item4_name')->nullable();
            $table->text('item4_desc')->nullable();
            $table->text('item4_price')->nullable();
            $table->text('item4_image')->nullable();

            $table->text('item5_name')->nullable();
            $table->text('item5_desc')->nullable();
            $table->text('item5_price')->nullable();
            $table->text('item5_image')->nullable();

            $table->text('item6_name')->nullable();
            $table->text('item6_desc')->nullable();
            $table->text('item6_price')->nullable();
            $table->text('item6_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecom_data');
    }
};

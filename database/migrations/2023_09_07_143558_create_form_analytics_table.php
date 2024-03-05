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
        Schema::create('form_analytics', function (Blueprint $table) {
          
            $table->uuid('id')->primary();
            //$table->unsignedBigInteger('page_id');
            $table->foreignUuid('link_id')
            ->constrained()
                ->references('id')
                ->on('links')
                ->onDelete('cascade');

            $table->date('date');
            $table->unsignedInteger('views')->default(0)->nullable();
            $table->unsignedInteger('uniqueviews')->default(0)->nullable();
            $table->unsignedInteger('clicks')->default(0)->nullable();
            $table->unsignedInteger('responces')->default(0)->nullable();
            $table->unsignedInteger('ctr')->default(0)->nullable();
            $table->unsignedInteger('conversion_rate')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_analytics');
    }
};

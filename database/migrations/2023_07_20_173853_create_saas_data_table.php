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
        Schema::create('saas_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_id');
            $table->foreign('link_id')
                ->references('id')
                ->on('links')
                ->onDelete('cascade');

            $table->text('description')->nullable();
            $table->text('category')->default('other')->nullable();
            $table->boolean('active')->default(true)->nullable();
            $table->string('mrr')->nullable();
            $table->text('saas_thumbnail')->nullable();
            $table->text('saas_category')->nullable();
            $table->text('saas_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saas_data');
    }
};

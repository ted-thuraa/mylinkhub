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
        Schema::create('socialmedia_links', function (Blueprint $table) {
            //$table->id();
            $table->uuid('id')->primary();
            //$table->unsignedBigInteger('page_id');
            $table->foreignUuid('user_id')
                ->constrained()
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->text('name')->nullable();
            $table->text('url')->nullable();
            $table->text('username')->nullable();
            $table->boolean('active')->default(false)->nullable();
            $table->unsignedInteger('clicks')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socialmedia_links');
    }
};

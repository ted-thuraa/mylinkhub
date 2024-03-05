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
        Schema::create('social_apps_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
    
            $table->text('name');
            $table->text('url')->nullable();
            $table->unsignedInteger('clicks')->default(0)->nullable();
            $table->text('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_apps_links');
    }
};

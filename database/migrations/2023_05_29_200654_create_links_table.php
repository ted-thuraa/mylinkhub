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
        
        Schema::create('links', function (Blueprint $table) {
<<<<<<< HEAD
            $table->id();
    
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
    
            $table->text('name')->nullable();
            $table->text('url')->nullable();
            $table->text('redirect_link')->nullable();
            $table->text('description')->nullable();
            $table->text('category')->default('other')->nullable();
            $table->boolean('active')->default(true)->nullable();
            $table->unsignedInteger('clicks')->default(0)->nullable();
            $table->text('image')->nullable();
            $table->text('layout')->nullable();
=======
            //$table->id();
            $table->uuid('id')->primary();
            //$table->unsignedBigInteger('page_id');
            $table->foreignUuid('user_id')
                ->constrained()
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('order')->default(0);
            $table->text('name')->nullable();
            $table->text('url')->nullable();
            $table->text('faviconurl')->nullable();
            $table->text('thumbnailurl')->nullable();
            $table->text('redirect_link')->nullable();
            $table->text('description')->nullable();
            $table->text('category')->default('other')->nullable();
            $table->boolean('active')->default(false)->nullable();
            $table->unsignedInteger('views')->default(0)->nullable();
            $table->unsignedInteger('clicks')->default(0)->nullable();
            $table->unsignedInteger('responces')->default(0)->nullable();
            $table->text('icon')->nullable();
            $table->text('thumbnailimage')->nullable();
            $table->text('layout')->nullable();
            $table->longText('data')->nullable();
            $table->string('google_sheets_url')->nullable();
            $table->unsignedInteger('google_sheets_submissions')->default(0)->nullable();
            $table->string('mailchimplistid')->nullable();
            $table->string('responces_email')->nullable();
            $table->string('responces_storage')->nullable();
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            $table->string('bg_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('btn_color')->nullable();
            $table->timestamps();
        });
    }

<<<<<<< HEAD
=======
    

>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};

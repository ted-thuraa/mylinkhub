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
        Schema::create('contact_form_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_id');
            $table->foreign('link_id')
                ->references('id')
                ->on('links')
                ->onDelete('cascade');
            $table->string('responses_email')->nullable();

            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('submission_message')->nullable();
            $table->text('category')->default('Contact')->nullable();
            $table->text('portfolio_thumbnail')->nullable();

            $table->boolean('useEmail')->default(true)->nullable();
            $table->boolean('useGoogleSheets')->default(false)->nullable();

            $table->boolean('get_name')->default(false)->nullable();
            $table->boolean('name_required')->default(false)->nullable();

            $table->boolean('get_email')->default(false)->nullable();
            $table->boolean('email_required')->default(false)->nullable();

            $table->boolean('get_mesaage')->default(false)->nullable();
            $table->boolean('message_required')->default(false)->nullable();

            $table->boolean('get_mobile')->default(false)->nullable();
            $table->boolean('mobile_required')->default(false)->nullable();

            $table->boolean('get_country')->default(false)->nullable();
            $table->boolean('country_required')->default(false)->nullable();

            $table->text('termsandcondition_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_form_data');
    }
};

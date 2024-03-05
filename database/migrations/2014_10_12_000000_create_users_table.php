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
        Schema::create('users', function (Blueprint $table) {
<<<<<<< HEAD
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('fullname')->nullable();
            $table->string('username')->unique();
            $table->string('bio')->nullable();
            $table->string('creator_category')->nullable();
            $table->text('image')->nullable();
            $table->string('email')->unique();
            $table->string('currentplan')->default('free')->nullable();
            $table->boolean('isAdmin')->default(false)->nullable();
            $table->string('country')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
=======
            //$table->id();
            $table->uuid('id')->primary(); 
            $table->string('authprovider')->nullable();
            $table->string('authprovider_id')->unique()->nullable();
            $table->boolean('authprovider_emailverified')->default(false)->nullable();
            $table->string('fullname')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('bio')->nullable();
            $table->string('creator_category')->nullable();
            $table->string('location')->nullable();
            $table->text('image')->nullable();
            $table->text('bg_image')->nullable();
            $table->string('page_font')->default('Inter')->nullable();
            $table->string('page_layout')->default('LunarLabyrinth')->nullable();
            $table->boolean('ishidelogo')->default(false)->nullable();
            $table->integer('theme_id')->default(1);
            $table->string('email')->unique();
            $table->string('currentplan')->default('free')->nullable();
            $table->string('mailchimpaccess_token')->nullable();
            $table->string('mailchimp_dc')->nullable();
            $table->string('googleaccess_token')->nullable();
            $table->string('googlerefresh_token')->nullable();
            $table->string('tokenexpires_in')->nullable();
            $table->boolean('isGooglesheetsAuthorized')->default(false)->nullable();
            $table->boolean('isMailchimpAuthorized')->default(false)->nullable();
            $table->boolean('isAdmin')->default(false)->nullable();
            $table->string('country')->nullable();
            $table->string('emailverification_code')->nullable();
            $table->boolean('is_email_verified')->default(0)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

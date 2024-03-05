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
        Schema::create('pagevisitorlocationdatas', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
=======
            //$table->unsignedBigInteger('page_id');
            $table->foreignUuid('user_id')
                ->constrained()
                ->references('id')
                ->on('users')
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
                ->onDelete('cascade');
            $table->string('ip', 45)->nullable();
            $table->string('country', 45)->nullable();
            $table->string('countryCode')->nullable();
            $table->string('cityName')->nullable();
            $table->string('areaCode')->nullable();
            $table->string('regionName')->nullable();
            $table->string('regionCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagevisitorlocationdatas');
    }
};

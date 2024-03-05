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
        Schema::create('pageanalytics', function (Blueprint $table) {
<<<<<<< HEAD
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
=======
            //$table->id();
            $table->uuid('id')->primary();
            //$table->unsignedBigInteger('page_id');
            $table->foreignUuid('user_id')
            ->constrained()
                ->references('id')
                ->on('users')
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
                ->onDelete('cascade');

            $table->date('date');
            $table->unsignedInteger('views')->default(0)->nullable();
            $table->unsignedInteger('clicks')->default(0)->nullable();
            $table->unsignedInteger('ctr')->default(0)->nullable();
            $table->unsignedInteger('uniquevisitors')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pageanalytics');
    }
};

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
        Schema::create('pages', function (Blueprint $table) {
<<<<<<< HEAD
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
=======
            //$table->id();
            $table->uuid('id')->primary();
            //$table->unsignedBigInteger('user_id');
            //$table->foreign('user_id')
            $table->foreignUuid('user_id')
                    ->constrained()
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('linkname')->unique();
<<<<<<< HEAD
=======
            $table->string('owner_fullname')->nullable();
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            $table->string('linkbio')->nullable();
            $table->integer('theme_id');
            $table->string('bio')->nullable();
            $table->text('bioimage')->nullable();
            $table->text('bg_image')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};

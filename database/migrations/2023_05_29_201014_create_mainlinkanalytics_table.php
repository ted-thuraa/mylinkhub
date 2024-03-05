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
        Schema::create('mainlinkanalytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
    
            $table->date('date');
            $table->unsignedInteger('views')->default(0)->nullable();
            $table->unsignedInteger('clicks')->default(0)->nullable();
            $table->unsignedInteger('ctr')->default(0)->nullable();
            $table->unsignedInteger('uniquevisitors')->default(0)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('country', 45)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mainlinkanalytics');
    }
};

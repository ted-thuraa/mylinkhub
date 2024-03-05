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
        Schema::create('form_responces', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Link::class, 'link_id');
            //$table->string('user_id');
            $table->string('form_type')->nullable();
            $table->string('sent_to')->nullable();
            $table->longText('answer_data')->nullable();
            $table->string('ip')->nullable();
            //$table->string('country_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_responces');
    }
};

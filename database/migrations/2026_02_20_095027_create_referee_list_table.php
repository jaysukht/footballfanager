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
        Schema::create('referee_list', function (Blueprint $table) {
            $table->id();
            $table->integer('referee_master_id');
            $table->string('referee_image');
            $table->string('referee_name');
            $table->integer('appearance')->nullable();
            $table->integer('fouls')->nullable();
            $table->integer('penalties')->nullable();
            $table->integer('yellow_cards')->nullable();
            $table->integer('red_cards')->nullable();
            $table->integer('language_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referee_list');
    }
};

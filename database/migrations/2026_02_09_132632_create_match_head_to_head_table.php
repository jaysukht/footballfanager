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
        Schema::create('match_head_to_head', function (Blueprint $table) {
            $table->id();
            $table->integer('match_id')->nullable();
            $table->string('goals')->nullable();
            $table->date('date')->nullable();
            $table->string('league')->nullable();
            $table->integer('language_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_head_to_head');
    }
};

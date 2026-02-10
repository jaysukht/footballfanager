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
        Schema::create('match_team_line_up', function (Blueprint $table) {
            $table->id();
            $table->integer('match_id')->nullable();
            $table->integer('row_number')->nullable();
            $table->integer('team')->nullable();
            $table->integer('player_id')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('number')->nullable();
            $table->string('pos')->nullable();
            $table->string('grid')->nullable();
            $table->integer('language_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_team_line_up');
    }
};

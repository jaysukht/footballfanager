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
        Schema::create('match_team_injured_player', function (Blueprint $table) {
            $table->id();
            $table->integer('match_id')->nullable();
            $table->integer('team')->nullable();
            $table->string('match_team_injuries_player_name')->nullable();
            $table->string('match_team_injuries_position')->nullable();
            $table->string('match_team_injuries_injury_type')->nullable();
            $table->string('match_team_injuries_image')->nullable();
            $table->integer('language_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_team_injured_player');
    }
};

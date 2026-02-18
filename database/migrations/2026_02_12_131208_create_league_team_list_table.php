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
        Schema::create('league_team_list', function (Blueprint $table) {
            $table->id();
            $table->integer('league_list_id');
            $table->integer('team_id');
            $table->string('team_name');
            $table->string('team_logo');
            $table->integer('team_points');
            $table->integer('team_goal_different');
            $table->string('team_form');
            $table->integer('team_all_played');
            $table->integer('team_all_win');
            $table->integer('team_all_draw');
            $table->integer('team_all_lose');
            $table->integer('team_all_goals_for');
            $table->integer('team_all_goals_against');
            $table->integer('team_all_points');
            $table->integer('team_home_played');
            $table->integer('team_home_win');
            $table->integer('team_home_draw');
            $table->integer('team_home_lose');
            $table->integer('team_home_goals_for');
            $table->integer('team_home_goals_against');
            $table->integer('team_home_points');
            $table->integer('team_away_played');
            $table->integer('team_away_win');
            $table->integer('team_away_draw');
            $table->integer('team_away_lose');
            $table->integer('team_away_goals_for');
            $table->integer('team_away_goals_against');
            $table->integer('team_away_points');
            $table->integer('language_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_team_list');
    }
};

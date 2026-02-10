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
        Schema::create('match_master', function (Blueprint $table) {
            $table->id();
            $table->string('post_title');
            $table->integer('home_team_id');
            $table->integer('away_team_id');
            $table->integer('fixture_id')->nullable();
            $table->integer('divan_matchid')->nullable();
            $table->integer('divanscore_home_id')->nullable();
            $table->integer('divanscore_away_id')->nullable();
            $table->integer('divanscore_tournament_id')->nullable();
            $table->integer('divanscore_season_id')->nullable();
            $table->date('match_date')->nullable();
            $table->time('match_time')->nullable();
            $table->string('referee_name')->nullable();
            $table->string('venue_name')->nullable();
            $table->string('city_name')->nullable();
            $table->string('match_result')->nullable();
            $table->string('match_homeresult')->nullable();
            $table->string('match_awayresult')->nullable();
            $table->string('match_team_players_team1_formation')->nullable();
            $table->string('match_team_players_team2_formation')->nullable();
            $table->integer('country_id');
            $table->integer('league_id');
            $table->integer('round_id');
            $table->integer('season_id');
            $table->integer('language_id');
            $table->integer('default_language_post_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_master');
    }
};

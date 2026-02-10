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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('post_title');
            $table->integer('team_id')->unique()->nullable();
            $table->integer('divanscore_home_id')->nullable();
            $table->integer('divanscore_away_id')->nullable();
            $table->integer('divanscore_tournament_id')->nullable();
            $table->integer('divanscore_season_id')->nullable();
            $table->text('team_logo')->nullable();
            $table->string('team_country')->nullable();
            $table->string('team_city')->nullable();
            $table->text('team_venue')->nullable();
            $table->string('team_manager')->nullable();
            $table->integer('league_id');
            $table->integer('season_id');
            $table->integer('language_id');
            $table->integer('default_language_post_id')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};

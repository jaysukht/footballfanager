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
        Schema::create('players_list', function (Blueprint $table) {
            $table->id();
            $table->integer('player_master_id');
            $table->integer('player_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('team_name');
            $table->integer('matches');
            $table->integer('goals_total');
            $table->integer('assists');
            $table->string('player_image');
            $table->string('team_image');
            $table->string('positions');
            $table->string('country');
            $table->integer('language_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players_list');
    }
};

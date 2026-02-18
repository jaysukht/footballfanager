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
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->integer('all_team_player_id');
            $table->integer('stat_type_id');
            $table->float('statistics_value');
            $table->float('statistics_percentage');
            $table->string('player_name');
            $table->string('player_position');
            $table->integer('player_id');
            $table->string('player_image');
            $table->integer('language_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_stats');
    }
};

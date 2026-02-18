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
        Schema::create('league_list_master', function (Blueprint $table) {
            $table->id();
            $table->string('post_title');
            $table->integer('season_id');
            $table->integer('league_id');
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
        Schema::dropIfExists('league_list_master');
    }
};

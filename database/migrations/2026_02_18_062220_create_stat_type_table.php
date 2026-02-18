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
        Schema::create('stat_type', function (Blueprint $table) {
            $table->id();
            $table->string('stat_name');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('stat_type');
    }
};

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
        Schema::create('watch_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('anime_id');
            $table->foreign('anime_id')->references('mal_id')->on('animes')->onDelete('cascade');
            $table->integer('last_episode_watched')->default(0);
            $table->integer('total_episodes')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->timestamp('watch_date');
            $table->timestamps();
            $table->unique(['user_id', 'anime_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watch_history');
    }
};

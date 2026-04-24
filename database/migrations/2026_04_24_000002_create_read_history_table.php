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
        Schema::create('read_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('manga_id');
            $table->foreign('manga_id')->references('mal_id')->on('mangas')->onDelete('cascade');
            $table->integer('last_chapter_read')->default(0);
            $table->integer('total_chapters')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->timestamp('read_date');
            $table->timestamps();
            $table->unique(['user_id', 'manga_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('read_history');
    }
};

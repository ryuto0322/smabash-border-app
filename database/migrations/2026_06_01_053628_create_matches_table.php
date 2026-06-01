<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. テーブル名を 'fighter_results' から 'matches' に変更！
        Schema::create('matches', function(Blueprint $table){
            $table->id();
            $table->foreignId('fighter_id')->constrained()->onDelete('cascade');
            $table->foreignId('opponent_fighter_id')->constrained('fighters')->onDelete('cascade');

            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};

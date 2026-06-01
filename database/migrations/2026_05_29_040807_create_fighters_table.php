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
        Schema::create('fighters', function (Blueprint $table) {
            $table->id();
            $table->string('name');//キャラクター名
            $table->biginteger('current_score');//戦闘力
            $table->integer('wins')->default(0);//勝った回数
            $table->integer('losses')->default(0);//負けた回数
            $table->string('image_path')->nullable();//string型の理由：画像を保存するのではなく、画像名を文字として記録するため。
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fighters');
    }
};

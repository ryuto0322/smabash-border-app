<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fighter extends Model
{
    // 👈 この1行を追加して、保存を許可する項目を指定します！
    protected $fillable = ['name', 'current_score', 'image_path'];

    /**
     * 各ファイターに紐づく戦績を取得
     */
    public function results()
    {
        return $this->hasMany(FighterResult::class, 'fighter_id');
    }
}
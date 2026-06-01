<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FighterResult extends Model
{
    protected $table = 'matches';

    protected $fillable = ['fighter_id','opponent_fighter_id','wins','losses'];


    public function fighter()
    {
        return $this->belongsTo(Fighter::class,'fighter_id');
    }
    public function opponentFighter()
    {
        return $this->belongsTo(Fighter::class, 'oppnent_fighter_id');
    }
}

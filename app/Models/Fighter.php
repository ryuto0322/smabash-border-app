<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fighter extends Model
{
    protected $fillable = ['name', 'current_score', 'wins','losses','image_path'];
}

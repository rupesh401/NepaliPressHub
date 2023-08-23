<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public function match()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}

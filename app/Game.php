<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function home()
    {
        return $this->belongsTo(Team::class, 'team_home_id');
    }

    public function away()
    {
        return $this->belongsTo(Team::class, 'team_away_id');
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function league() {

        return $this->belongsToMany('App\League', 'team_legs');
    }

    public function table(){

        return $this->belongsToMany('App\Table', 'team_tables');
    }
}

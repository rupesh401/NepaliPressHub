<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    public function team() {

        return $this->belongsToMany('App\Team', 'team_legs');
    }
    
    public function table() {

        return $this->belongsToMany('App\Table', 'table_legs');
    }
}

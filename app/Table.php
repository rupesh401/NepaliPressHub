<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public function team(){

        return $this->belongsToMany('App\Team', 'team_tables');
    }
}

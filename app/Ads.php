<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    public function prv()
    {
        return $this->belongsToMany('App\Province', 'prov_ads');
    }
}

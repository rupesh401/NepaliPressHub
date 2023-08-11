<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function post()
    {
        return $this->belongsToMany('App\Post', 'post_provs');
    }

    public function ads()
    {
        return $this->belongsToMany('App\Ads', 'prov_ads');
    }
}

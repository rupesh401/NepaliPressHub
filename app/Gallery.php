<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function img()
    {
        return $this->belongsToMany('App\Image', 'gal_mages');
    }
}

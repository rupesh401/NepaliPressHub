<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function gal()
    {
        return $this->belongsToMany('App\Gallery', 'gal_mages');
    }
}

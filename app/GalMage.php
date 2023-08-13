<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalMage extends Model
{
    protected $table = 'gal_mages'; // Replace with the actual pivot table name
    // You might not need timestamps columns in pivot tables
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $fillable = ['tag_id', 'post_id'];
}

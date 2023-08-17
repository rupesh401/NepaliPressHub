<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Define the hasMany relationship with Post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    // Define the hasMany relationship with Post
    public function reply()
    {
        return $this->belongsToMany('App\Reply', 'com_replies');
    }

    protected $fillable = ['name', 'email', 'comment', 'status'];
}

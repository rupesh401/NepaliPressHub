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
    // public function post()
    // {
    //     return $this->belongsTo(Post::class);
    // }

    // public function post()
    // {
    //     return $this->belongsTo(Post::class, 'post_comments');
    // }

    protected $fillable = ['name', 'email', 'comment', 'status'];
}

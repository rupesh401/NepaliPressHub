<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'likes',
    ];
    public function usr()
    {
        return $this->belongsToMany('App\User', 'user_posts');
    }
    public function tag()
    {
        return $this->belongsToMany('App\Tag', 'post_tags');
    }

    public function cat()
    {
        return $this->belongsToMany('App\Category', 'post_cats');
    }
    
    public function com()
    {
        return $this->belongsToMany('App\Comment', 'post_comments');
    }

    public function prov()
    {
        return $this->belongsToMany('App\Province', 'post_provs');
    }

    // public function comments(): HasMany
    // {
    //     return $this->hasMany(Comment::class);
    // }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class, 'post_comments');
    // }
}

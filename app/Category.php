<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Category extends Model
{
    // Define the hasMany relationship with Post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

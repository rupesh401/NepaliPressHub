<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
       'user_agent', 'ip_address', ' user_id ', 'login_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

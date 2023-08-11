<?php

namespace App\Listeners;

use Jenssegers\Agent\Agent;
use IlluminateAuthEventsLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $agent = new Agent();
        $userAgent = $agent->getUserAgent();
        
        $event->user->loginLogs()->create([
            'ip_address' => request()->ip(),
            'login_time' => now(),
            'user_agent' => $userAgent,
        ]);
    }
}

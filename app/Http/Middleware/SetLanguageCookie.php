<?php

namespace App\Http\Middleware;

use Closure;

class SetLanguageCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = $request->cookie('language'); // Check if a language cookie already exists

        if (!$language) {
            $language = 'en'; // Set the default language (you can change this to any desired default language)
            $minutes = 60 * 24 * 30; // 30 days expiration time for the cookie

            return $next($request)->cookie('language', $language, $minutes);
        }

        return $next($request);
    }
}

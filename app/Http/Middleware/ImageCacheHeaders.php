<?php

namespace App\Http\Middleware;

use Closure;

class ImageCacheHeaders
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
        $response = $next($request);

        if ($response->isSuccessful() && $response->headers->get('Content-Type', '') === 'image/jpeg') {
            $response->header('Cache-Control', 'public, max-age=31536000');
            $response->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        }

        return $response;
    }
}

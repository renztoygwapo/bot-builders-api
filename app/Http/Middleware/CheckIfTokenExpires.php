<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfTokenExpires
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $currentAccessToken = (object) $request->user()->currentAccessToken();
        
        if ($currentAccessToken && now()->gt($currentAccessToken->expires_at)) {
            // $currentAccessToken->delete();
            abort(403, 'Invalid or expired token.');
        }

        return $next($request);
    }
}

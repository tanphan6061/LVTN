<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkGotoPreviousPageAfterLogout
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
        return $next($request)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate,  pre-check=0, post-check=0, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}

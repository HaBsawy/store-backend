<?php

namespace App\Http\Middleware;

use App\Helper\JsonResponder;
use Closure;

class Verified
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
        if (!auth()->check()) {
            return JsonResponder::make('', false, 401, 'unauthorized');
        }

        if (auth()->user()->email_verified_at !== null) {
            return $next($request);
        }
        return JsonResponder::make('', false, 403, 'you must verify your email');
    }
}

<?php

namespace App\Http\Middleware;

use App\Helper\JsonResponder;
use Closure;

class Admin
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
        } else {
            if (auth()->user()->role !== 'admin') {
                return JsonResponder::make('', false, 403, 'access denied');
            }
        }
        return $next($request);
    }
}

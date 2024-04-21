<?php

namespace Hankz\LaravelPlusApi\Middleware;

use Closure;

class SetHeaderAcceptJson
{
    /**
     * Handle an incoming request.
     *
     * @param Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}

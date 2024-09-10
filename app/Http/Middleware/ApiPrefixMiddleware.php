<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiPrefixMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('api/*')) {
            $request->merge(['prefix' => 'api']);
        }

        return $next($request);
    }
}
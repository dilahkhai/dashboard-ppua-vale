<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveTaskMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('api/task/*')) {
            $request->merge(['path' => str_replace('/task', '', $request->path())]);
        }

        return $next($request);
    }
}
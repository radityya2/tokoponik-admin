<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('login')) {
            $token = $request->header('Authorization');

        }

        return $next($request);
    }
}

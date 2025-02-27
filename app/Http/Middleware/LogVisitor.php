<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\V;

class LogVisitor
{
    // public function handle(Request $request, Closure $next)
    // {
    //     VisitorLog::create([
    //         'ip_address' => $request->ip(),
    //         'user_agent' => $request->header('User-Agent')
    //     ]);

    //     return $next($request);
    // }
}

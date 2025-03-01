<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LogVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $today = now()->format('Y-m-d');

        // Kiểm tra xem IP đã tồn tại trong database hôm nay chưa
        $exists = DB::table('visitor_logs')
            ->where('ip_address', $ip)
            ->whereDate('visited_at', $today)
            ->exists();

        if (!$exists) {
            DB::table('visitor_logs')->insert([
                'ip_address' => $ip,
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}

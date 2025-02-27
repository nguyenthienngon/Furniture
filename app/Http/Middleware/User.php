<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
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
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Bạn cần đăng nhập để thực hiện hành động này.');
        }

        // Tiếp tục với request nếu người dùng đã đăng nhập
        return $next($request);
    }
}

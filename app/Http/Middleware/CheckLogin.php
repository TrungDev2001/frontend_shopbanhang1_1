<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        if (auth()->check()) { //nếu đã đăng nhập thì chuyển hướng đến trang admin
            return $next($request);
        } else {
            return redirect('/authentication');
        };
    }
}

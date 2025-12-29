<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'MANAGER') {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงส่วนนี้');
        }

        return $next($request);
    }
}

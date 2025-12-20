<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class SetLocale
{
    public function handle(Request $request, Closure $next)
    {

         $locale = Session::get('locale', 'th'); // default ภาษาไทย
        App::setLocale($locale);

        return $next($request);
        // allow เฉพาะที่รองรับ
        $allowed = ['th', 'en'];
        if (!in_array($lang, $allowed)) {
            $lang = 'th';
        }

        app()->setLocale($lang);

        // รองรับ 3 แหล่ง: URL (?lang=en) > session > cookie
       $lang = $request->query('lang')
            ?? ($request->hasSession() ? $request->session()->get('lang') : null)
            ?? $request->cookie('lang')
            ?? 'th';
            
        // ถ้ามีส่งมาจาก URL ให้ “บันทึกลง session” อัตโนมัติ
        if ($request->has('lang')) {
            $request->session()->put('lang', $lang);
        }

        return $next($request);
    }
}

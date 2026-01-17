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
        // 1. ตรวจสอบว่ามีค่าภาษาใน Session หรือไม่ (ถ้าไม่มีให้เป็น 'th')
        // ชื่อ Key ต้องตรงกับที่ใช้ใน Route (ในที่นี้ใช้ 'lang')
        $lang = Session::get('lang', 'th');

        // 2. ตรวจสอบว่าเป็นภาษาที่อนุญาตเท่านั้น
        if (!in_array($lang, ['th', 'en'])) {
            $lang = 'th';
        }

        // 3. ตั้งค่าภาษาให้ระบบ
        App::setLocale($lang);

        return $next($request);
    }
}
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
        $lang = Session::get('lang', 'th');

        if (!in_array($lang, ['th', 'en'])) {
            $lang = 'th';
        }

        App::setLocale($lang);

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = session('locale', config('locales.default'));

        // Set ngôn ngữ
        App::setLocale($locale);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->session()->get('locale');
        if ($locale && in_array($locale, ['de', 'en'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $header_lang = ($request->header('lang') != '') ? $request->header('lang') : 'en';
        if (isset($header_lang) && in_array($header_lang, config('app.available_locales'))) {
            app()->setLocale($header_lang);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ChangeMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session()->has('change_mode')) {
            Config::set('app.mode_theme', Session()->get('change_mode'));
        } else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            Config::set('app.mode_theme', 'dark');
        }

        return $next($request);
    }
}

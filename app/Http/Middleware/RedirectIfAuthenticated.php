<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        } elseif (Auth::guard('user')->check()) {
            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}

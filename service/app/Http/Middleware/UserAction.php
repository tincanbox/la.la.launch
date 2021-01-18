<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class UserAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $prev = session('previousUrl');

        if ($request->method() == 'GET' && $prev !== url()->previous()) {
            session(['previousUrl' => url()->previous()]);
        }

        return $next($request);
    }
}

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
        //Auth::guard('web')->logout();
        $prev = session('previousUrl');

        if ($prev !== url()->previous()) {
            session(['previousUrl' => url()->previous()]);
        }

        return $next($request);
    }
}

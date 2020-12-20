<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;
use Inertia\Middleware;

/*
|----------------------------------------------------------------
| Via the HandleInertiaRequests middleware (recommended)
|----------------------------------------------------------------
*/

class HandleInertiaRequests extends Middleware
{
    function handle($request, Closure $next): Response
    {
        Inertia::share([

            // Synchronously
            // Don't override predefined properties,
            // like: app currentRouteName errorBags errors jetstream sessions
            'info' => [
                'name' => config('app.name')
            ],

            'flash' => [
                'message' => function($request){ return $request->session()->get('message'); }
            ],

            // Lazily
            'user' => (function($request){
                return $request->user() ? $request->user()->only('id', 'name', 'email') : null;
            }),
        ]);

        return parent::handle($request, $next);
    }

    // Middleware::share is not defined... meant be ResponseFactory::share??
    public function share(Request $request)
    {
    }
}

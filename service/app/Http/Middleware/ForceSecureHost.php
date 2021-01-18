<?php

namespace App\Http\Middleware;

class ForceSecureHost
{
    /**
     */
    function handle($request, $next)
    {
        if($this->app->environment('production')) {
            $appurl = preg_replace('/\/$/', '', \Config::get('app.url'));
            $origin = preg_replace('/\/$/', '', $request->getSchemeAndHttpHost());
            if ($origin !== $appurl) {
                \URL::forceRootUrl($appurl);
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class UserPreferredLanguage {

  const LANGUAGE_TOGGLE_QUERY = 'lang';
  const SESSION_KEY = 'userPreferredLanguage';

  public function handle(Request $request, Closure $next) {
    /** @var Session $session */
    $session = $request->getSession();
    $language = null;
    $languages = config('languages');

    // Override
    if ($request->has(self::LANGUAGE_TOGGLE_QUERY)) {
      $lang = $request->get(self::LANGUAGE_TOGGLE_QUERY);
      if (array_key_exists($lang, $languages)) {
        $language = $lang;
      }
    }

    // User pref
    if ($user = $request->user()) {
      $meta = $user->meta;
      if ($meta) {
        if ($language) {
          $meta->language = $language;
          $meta->save();
        } else {
          if (array_key_exists($meta->language, $languages)) {
            $language = $meta->language;
          }
        }
      } else {
        $meta = $user->createMeta();
        if ($language) {
          $meta->language = $language;
          $meta->save();
        }
      }
    }

    if (!$language) {
      $language = $request->getPreferredLanguage(array_keys($languages));
    }

    $session->put(self::SESSION_KEY, $language);
    app()->setLocale($language);

    return $next($request);
  }
}
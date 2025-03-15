<?php

namespace App\Http\Middleware;

use Closure; // Import the global Closure class
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    public function handle($request, Closure $next) // Use the imported Closure here
    {
        $locale = session('locale', config('app.locale'));
        App::setLocale($locale);
        return $next($request); // Pass the request to the next middleware
    }
}

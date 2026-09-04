<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $duration = \App\Models\Setting::first()->token_duration ?? 30;
        
        // Token is generated based on APP_KEY and the current dynamic window
        $timeWindow = floor(time() / $duration);
        $appKey = env('APP_KEY', 'default_key');
        
        $tokenCurrent = substr(md5($appKey . $timeWindow), 0, 8);
        $tokenPrevious = substr(md5($appKey . ($timeWindow - 1)), 0, 8);

        $providedToken = $request->query('token');

        // Check if the provided token is valid for the current or previous window
        if ($request->isMethod('get') && $providedToken && ($providedToken === $tokenCurrent || $providedToken === $tokenPrevious)) {
            session(['has_valid_dynamic_token' => true]);
        }

        if (!session('has_valid_dynamic_token')) {
            return redirect('/');
        }

        return $next($request);
    }
}

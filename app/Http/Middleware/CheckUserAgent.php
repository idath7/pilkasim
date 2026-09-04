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
        $providedToken = $request->query('token');

        // Check if the provided token is in cache and pending
        if ($request->isMethod('get') && $providedToken) {
            $status = \Illuminate\Support\Facades\Cache::get('kiosk_token_' . $providedToken);
            if ($status === 'pending') {
                \Illuminate\Support\Facades\Cache::put('kiosk_token_' . $providedToken, 'used', now()->addMinutes(60));
                session(['has_valid_dynamic_token' => true]);
            }
        }

        if (!session('has_valid_dynamic_token')) {
            if (session('voter_id')) {
                return redirect()->route('scanner')->with('error', 'Silakan scan QR Kiosk terlebih dahulu.');
            }
            return redirect('/login');
        }

        return $next($request);
    }
}

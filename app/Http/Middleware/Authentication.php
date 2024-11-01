<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth;

class Authentication
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $url = 'http://127.0.0.1:8000';
        $guard = $request->route()->parameter('guard') ?? 'web'; 

        if (!Auth::guard($guard)->check()) {
            throw new AccessDeniedHttpException('Anda harus login untuk mengakses halaman ini.');
        }

        $user = Auth::guard($guard)->user();
        // if (Auth::guard('petugas')->check()) {

        // return redirect('/app');

        // } else if (Auth::guard('masyarakat')->check()) {

        // return redirect('/dashboard');
        
        // }

        $response = $next($request);
        $response->headers->set('Dawala', $url);
        if ($response->headers->has('Dawala')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache');
        }

        return $response;
    }

}

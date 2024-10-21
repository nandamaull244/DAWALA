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

        if (!Auth::check()) {
            throw new AccessDeniedHttpException('Anda harus login untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        if (!empty($roles) && !in_array($user->role, $roles)) {
            throw new AccessDeniedHttpException('Anda tidak memiliki hak akses');
        }

        $response = $next($request);

        $response->headers->set('Dawala', $url);
        
        if ($response->headers->has('Dawala')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache');
            // $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }

        return $response;
    }
}

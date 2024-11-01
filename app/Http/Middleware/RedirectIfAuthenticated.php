<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guards = null)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            return redirect()->route($user->role . '.dashboard')->with('success', "Anda berhasil Login sebagai " . ucfirst($user->role));
        } else if (Auth::guard('client')->check()) {
            $user = Auth::guard('client')->user();
            switch ($user->role) {
                case 'instance':
                    if ($user->registration_status == 'Completed') {
                        return redirect()->route('instance.pelayanan.index')->with('success', 'Anda berhasil Login sebagai Instansi, ' . $user->instance->name);
                    }
                    $error = $user->registration_status === 'Rejected' 
                        ? 'Pengajuan pendaftaran akun ditolak oleh Admin!' 
                        : 'Akun anda belum terdaftar sebagai instansi, silakan menunggu admin untuk melakukan verifikasi.';
                    return redirect()->back()->with('error', $error);

                case 'user':
                    return redirect()->route('user.pelayanan.index')->with('success', 'Selamat Datang di Sistem DAWALA, ' . $user->full_name);
            }
        }
        return $next($request);
    }
}

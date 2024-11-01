<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
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
    }
}

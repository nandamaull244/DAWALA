<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view("Authentication.login");
    }
    public function loginProcess(Request $request)
    {
            try {
                $user = $request-> validate([
                    'username' => ['required'],
                    'password' => ['required'],
                ]);
                if(Auth::attempt($user)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard')->with('success','Anda berhasil Login');
                } else{
                    return redirect()->back()->with('error','Username atau Password tidak sesuai');
                }
                throw ValidationException::withMessages([
                    'username' => 'Data yang Anda masukan tidak ditemukan',
                ]);
        
            }   catch(\Exception | PDOException | QueryException){
                return redirect()->back()->with('error','Username atau password tidak sesuai');
            }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success','Anda berhasil logout');
    }

    public function register(Request $request)
    {
        return view("Authentication.register");
    }
    
}
<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Tambahkan ini untuk menangkap pesan sukses dari registrasi
        $successMessage = session('success');
        return view("Authentication.login", compact('successMessage'));
    }
    public function loginProcess(Request $request)
    {
        try {
            $user = $request-> validate([
                'nik' => ['required'],
                'password' => ['required'],
            ]);
            if(Auth::attempt($user)) {
                $request->session()->regenerate();
                return redirect()->intended('/register')->with('success','Anda berhasil Login');
            } else{
                return redirect()->back()->with('error','NIK atau Password tidak sesuai');
            }
            throw ValidationException::withMessages([
                'nik' => 'Data yang Anda masukan tidak ditemukan',
            ]);
    
        }   catch(\Exception | PDOException | QueryException){
            return redirect()->back()->with('error','NIK atau password tidak sesuai');
        }
    }
    public function loginAdmin(Request $request)
    {
        $successMessage = session('success');
        return view("Authentication.loginAdmin", compact('successMessage'));
    }
    public function loginAdminProcess(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
            
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->role !== 'admin') {
                    Auth::logout();
                    return redirect()->back()->with('error', 'Anda tidak memiliki akses sebagai admin.');
                }

                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard')->with('success', 'Anda berhasil Login sebagai Admin');
            }
            return 'a';
            return redirect()->back()->with('error', 'Username atau Password tidak sesuai');

        } catch (\Exception | PDOException | QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success','Anda berhasil logout');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginAdmin.index')->with('success', 'Anda berhasil logout dari admin.');
    }

    public function register(Request $request)
    {
        return view("Authentication.register");
    }

    //proses register
    public function registerProcess(Request $request)
    {
        //validasi data
        $validator = Validator::make($request->all(),[
            'nik' => 'required|string|digits:16',
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|string',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'no_kk' => 'required|string|digits:16',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|digits_between:11,12',
            'role' => 'required|in:admin,operator,user,collector',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'registration_type' => 'required|string',

        ]);
        //jika validasi gagal
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // membuat user baru
            $user = User::create([
                'nik' => $request->nik,
                'full_name' => $request->full_name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'no_kk' => $request->no_kk,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password), // Hashing password sebelum disimpan
                'role' => $request->role, // Set role based on user selection
                'registration_status' => $request->role === 'user' ? 'Completed' : 'Process', // Set status based on user selection
                'registration_type' => $request->role === 'collector' ? $request->registration_type : 'User, Perorangan', // Set registration type based on user selection
            ]);

            // Jika berhasil
            return redirect()->route('login.index')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } catch (\Exception $e) {
            // Jika gagal
            return redirect()->route('register')->with('error', 'Pendaftaran gagal! Silakan coba lagi.')->withInput();
        }
    }
    
    public function forgotPassword()
    {
        return view('Authentication.forgot_password');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login.index')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }
    }
}

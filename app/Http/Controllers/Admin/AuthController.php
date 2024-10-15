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
            'role' => 'required|in:admin,operator,user',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'registration_type' => 'required|string',

        ]);
        //jika validasi gagal
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //membuat user baru
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
            'registration_type' => $request->role === 'kolektor' ? $request->registration_type : 'Perorangan', // Set registration type based on user selection
        ]);

        //setelah berhasil register, arahkan ke halaman login atau tampilkan pesan sukses
        return redirect()->route('login.index')->with('success','Anda berhasil register');
    
    }
    
}
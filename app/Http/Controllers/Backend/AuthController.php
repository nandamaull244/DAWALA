<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\District;
use App\Models\Village;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view("Authentication.login")->with('success', 'Berhasil Login');
    }

    public function loginProcess(Request $request)
    {
        try {
            $credentials = $request->validate([
                'nik' => ['required'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();

                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard')->with('success', 'Anda berhasil Login sebagai Admin');
                    case 'operator':
                        return redirect()->route('operator.dashboard')->with('success', 'Anda berhasil Login sebagai Operator');
                    case 'institute':
                        return redirect()->route('institute.dashboard')->with('success', 'Anda berhasil Login sebagai Instansi');
                    case 'user':
                        return redirect()->route('user.dashboard')->with('success', 'Selamat Datang di Sistem DAWALA, ' . $user->full_name);
                }
            } else {
                return redirect()->back()->with('error', 'NIK atau Password tidak sesuai');
            }
        } catch (\Exception | PDOException | QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index')->with('success','Anda berhasil logout');
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
                
                switch ($user->role) {
                    case 'admin':
                        $request->session()->regenerate();
                        return redirect()->intended('/admin/dashboard')->with('success', 'Anda berhasil Login sebagai Admin');
                    case 'operator':
                        $request->session()->regenerate();
                        return redirect()->intended('/operator/dashboard')->with('success', 'Anda berhasil Login sebagai Operator');
                    default:
                        Auth::logout();
                        return redirect()->back()->with('error', 'Anda tidak memiliki akses yang sesuai.');
                }
            }
           
            return redirect()->back()->with('error', 'Username atau Password tidak sesuai');

        } catch (\Exception | PDOException | QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
        }
    }

    public function logoutAdmin(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login-admin.index')->with('success', 'Anda berhasil logout dari admin.');
    }

    public function register(Request $request)
    {
        $districts = District::orderBy('name', 'asc')->get();
        $villages = Village::orderBy('name', 'asc')->get();
        return view("Authentication.register", compact('districts', 'villages'));
    }

    public function registerProcess(Request $request)
    {
        $rules = [
            'nik' => 'required|string|digits:16',
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|string',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'no_kk' => 'required|string|digits:16',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|digits_between:10,14',
            'role' => 'required|in:admin,operator,user,institute',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        if ($request->input('role') === 'institute') {
            $rules['registration_type'] = 'required|string';
            $rules['village_id'] = 'required|exists:villages,id';
        }

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){
            $errors = $validator->errors();
            $errorMessages = [];
            foreach ($errors->all() as $message) {
                $errorMessages[] = $message;
            }
            $errorMessage = implode('<br>', $errorMessages);
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessage);
        }

        try {
            $user = User::create([
                'nik' => $request->nik,
                'full_name' => $request->full_name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'no_kk' => $request->no_kk,
                'email' => $request->email,
                'district_id' => $request->role === 'institute' ? $request->district_id : null,
                'village_id' => $request->role === 'institute' ? $request->village_id : null,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'registration_status' => $request->role === 'user' ? 'Completed' : 'Process',
                'registration_type' => $request->role === 'institute' ? $request->registration_type : 'User, Perorangan',
            ]);

            return redirect()->route('login.index')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } catch (\Exception $e) {
            return redirect()->route('register.index')->with('error', 'Pendaftaran gagal! Silakan coba lagi.')->withInput();
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

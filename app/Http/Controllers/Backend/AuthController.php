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
use Illuminate\Support\Facades\DB;
use App\Models\Instance;

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

                    case 'instance':
                        if ($user->registration_status == 'Completed') {
                           
                            return redirect()->route('instance.pelayanan.index')->with('success', 'Anda berhasil Login sebagai Instansi, ' . $user->instance->name);
                        } else {
                            return redirect()->back()->with('error', 'Akun anda belum terdaftar sebagai instansi, silakan menunggu admin untuk melakukan verifikasi.');
                        }
                    case 'user':
                        return redirect()->route('user.pelayanan.index')->with('success', 'Selamat Datang di Sistem DAWALA, ' . $user->full_name);
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
        $role = Auth::user()->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        $message = $role === 'operator' 
            ? 'Anda berhasil Logout dari Operator.'
            : 'Anda berhasil Logout dari Admin.';

        
        return redirect()->route('login-admin.index')->with('success', $message);
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
            'rt' => 'required|string',
            'rw' => 'required|string',
            'address' => 'required|string',
            'no_kk' => 'required|string|digits:16',
            'email' => 'email|unique:users,email',
            'phone_number' => 'required|string|digits_between:10,14',
            'role' => 'required|in:admin,operator,user,instance',
            'password' => 'required|min:8|confirmed',
        ];


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
            DB::beginTransaction();
            
            $user = User::create([
                'nik' => $request->nik,
                'full_name' => $request->full_name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'address' => $request->address,
                'no_kk' => $request->no_kk,
                'email' => $request->email,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'registration_status' => $request->role === 'user' ? 'Completed' : 'Process',
                'registration_type' => $request->role === 'instance' ? $request->registration_type : 'User, Perorangan',
            ]);

            if ($request->role === 'instance') {
                Instance::create([
                    'user_id' => $user->id,
                    'name' => $request->instansi,
                ]);
            }

            DB::commit();
            return redirect()->route('login.index')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();
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

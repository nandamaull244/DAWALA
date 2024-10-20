<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\District;
use App\Models\Village;
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
                    case 'instantiation':
                        return redirect()->route('instantiation.dashboard')->with('success', 'Anda berhasil Login sebagai Instantiation');
                    case 'user':
                    default:
                        return redirect()->route('user.dashboard')->with('success', 'Anda berhasil Login');
                }
            } else {
                return redirect()->back()->with('error', 'NIK atau Password tidak sesuai');
            }
        } catch (\Exception | PDOException | QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
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
        $districts = District::all();
        $villages = Village::all();
        return view("Authentication.register", compact('districts', 'villages'));
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
            'role' => 'required|in:admin,operator,user,instantiation',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'registration_type' => 'required|string',
            'village_id' => 'required_if:role,instantiation|exists:villages,id',
        
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
                'district_id' => $request->role === 'instantiation' ? $request->district_id : null,
                'village_id' => $request->role === 'instantiation' ? $request->village_id : null,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'registration_status' => $request->role === 'user' ? 'Completed' : 'Process',
                'registration_type' => $request->role === 'instantiation' ? $request->registration_type : 'User, Perorangan',
            ]);

            // Jika berhasil
        
            return redirect()->route('login.index')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } catch (\Exception $e) {
            // Jika gagal
            dd($e);
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

    public function showRegistrationForm()
    {
        $districts = District::all();
        return view('Authentication.register', compact('districts'));
    }

    public function getVillagesByDistrict($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get();
        return response()->json($villages);
    }

}

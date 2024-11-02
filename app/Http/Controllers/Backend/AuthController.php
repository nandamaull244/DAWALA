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

    public function loginUserProcess(Request $request)
    {
        try {
            $credentials = [
                'nik' => $request->nik,
                'password' => $request->password,
            ];

            // Check user first without logging them in
            $user = User::where('nik', $credentials['nik'])->first();

            if (Auth::guard('client')->attempt($credentials)) {
                $user = Auth::guard('client')->user();

                switch ($user->role) {
                    case 'instance':
                        return redirect()->route('instance.layanan.index')->with('success', 'Anda berhasil Login sebagai Instansi, ' . $user->instance->name);
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

    public function loginAdminProcess(Request $request)
    {
        try {
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];

            if (Auth::guard('admin')->attempt($credentials)) {
                $user = Auth::guard('admin')->user();

                // Prevent login for instance users with Process or Rejected status
                if ($user && $user->role === 'instance') {
                    if ($user->registration_status !== 'Completed') {
                        $message = $user->registration_status === 'Process' 
                            ? 'Akun anda belum disetujui, silakan menunggu admin untuk melakukan verifikasi.'
                            : 'Pengajuan pendaftaran akun ditolak oleh Admin!';
                        return redirect()->back()->with('error', $message);
                    }
                }

                // Add registration status check to credentials for instances
                if ($user && $user->role === 'instance') {
                    $credentials['registration_status'] = 'Completed';
                }

                return redirect()->route($user->role . '.dashboard')->with('success', "Anda berhasil Login sebagai " . ucfirst($user->role));
            } else {
                return redirect()->back()->with('error', 'Username atau Password tidak sesuai');
            }
        } catch (\Exception | PDOException | QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat login: ' . $e->getMessage());
        }
    }

    public function logout(Request $request){
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else if (Auth::guard('client')->check()) {
            Auth::guard('client')->logout();
        }
        return redirect()->route('login.index')->with('success','Anda berhasil logout');
    }

    public function register(Request $request)
    {
        $districts = District::orderBy('name', 'asc')->get();
        $villages = Village::orderBy('name', 'asc')->get();
        return view("Authentication.register", compact('districts', 'villages'));
    }

    public function cekNIK(Request $request) 
    {
        $user = User::where('nik', $request->nik)->first();
        return response()->json(!empty($user) ? true : false);
    }

    public function registerProcess(Request $request)
    {
        $rules = [
            'nik' => 'required|string|digits:16',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'address' => 'required|string',
            'no_kk' => 'required|string|digits:16',
            'email' => 'email',
            'username' => 'nullable|string|max:255',
            'phone_number' => 'required|string',
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
                'birth_date' => $request->birth_date ? $request->birth_date : now()->format('Y-m-d'),
                'gender' => $request->gender,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'address' => $request->address,
                'no_kk' => $request->no_kk,
                'email' => $request->email,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'phone_number' => $request->phone_number,
                'username' => $request->role === 'instance' ? $request->username : null,
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

    public function cekUsername(Request $request)
    {
        $username = $request->username;
    $exists = User::where('username', $username)->exists();
        return response()->json($exists);
    }
}


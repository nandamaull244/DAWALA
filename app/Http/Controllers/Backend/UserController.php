<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\District;
use App\Models\Village;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\District;
// use App\Models\Village;
use Yajra\DataTables\Facades\DataTables;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $districts = District::with('villages')->get();
        $villages = Village::all();
        $users = User::whereIn('registration_status', ['Completed', 'Rejected'])->get();
        return view('akun-manajemen.index', compact('districts', 'villages', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::with('villages')->get();
        $villages = Village::all();
        return view('akun-manajemen.form_user', compact('districts', 'villages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|digits_between:10,14',
            'role' => 'required|in:admin,operator,user,instantiation',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        if ($request->input('role') === 'instantiation') {
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
                'rt' => $request->rt,
                'rw' => $request->rw,
                'address' => $request->address,
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

            return redirect()->route('admin.akun-manajemen.index')
                           ->with('success', 'Akun berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->route('admin.akun-manajemen.create')->with('error', 'Pendaftaran gagal! Silakan coba lagi.')->withInput();
        }
     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $districts = District::with('villages')->get();
        $villages = Village::all();
        $user = User::findOrFail($id);
        return view('akun-manajemen.modal_edit_akun', compact('user', 'districts', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validate = $request->validate([
            'nik' => 'string|digits:16',
            'full_name' => 'string|max:255',
            'birth_date' => 'string',
            'gender' => 'in:Laki-Laki,Perempuan',
            'rt' => 'string',
            'rw' => 'string',
            'address' => 'string',
            'district_id' => 'exists:districts,id',
            'village_id' => 'exists:villages,id',
            'no_kk' => 'string|digits:16',
            'email' => 'email|unique:users,email,' . $id,
            'phone_number' => 'string|digits_between:10,14',
            'registration_type' => 'string',
        ]);

        $user->update($validate);
        return redirect()->route('admin.akun-manajemen.index')->with('success', 'Akun berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verificationTable()
    {   
        $districts = District::with('villages')->get();
        $villages = Village::all();
        $users = User::whereIn('registration_status', ['Process'])->get();
        return view('akun-manajemen.verification_table', compact('districts', 'villages', 'users'));
    }

    public function getData(Request $request)
    {
        $query = User::with(['district', 'village'])
            ->whereIn('registration_status', ['Completed', 'Rejected'])
            ->where('role', '!=', 'admin')
            ->select([
                'id',
                'nik',
                'no_kk',
                'username',
                'email',
                'phone_number',
                'full_name',
                'birth_date',
                'gender',
                'address',
                'rt',
                'rw',
                'district_id',
                'village_id',
                'role',
                'registration_type',
                'registration_status'
            ]);

        // Apply filters
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('registration_type') && $request->registration_type != '') {
            $query->where('registration_type', $request->registration_type);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('registration_status', $request->status);
        }

        if ($request->has('district_id') && $request->district_id != '') {
            $query->where('district_id', $request->district_id);
        }

        if ($request->has('village_id') && $request->village_id != '') {
            $query->where('village_id', $request->village_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button onclick=\'openEditModal('.json_encode($row).')\'
                        style="cursor: pointer; border: none; background: none; padding: 0;">✏️</button> ';
                return $btn;
            })
            ->addColumn('district_name', function($row) {
                return $row->district ? $row->district->name : '-';
            })
            ->addColumn('village_name', function($row) {
                return $row->village ? $row->village->name : '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getVerificationData(Request $request)
    {
        $query = User::with(['district', 'village'])
            ->where('registration_status', 'Process')
            ->where('role', '!=', 'admin')
            ->select([
                'id',
                'nik',
                'no_kk',
                'username',
                'email',
                'phone_number',
                'full_name',
                'birth_date',
                'gender',
                'address',
                'rt',
                'rw',
                'district_id',
                'village_id',
                'role',
                'registration_type',
                'registration_status'
            ]);

        // Apply filters
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('registration_type') && $request->registration_type != '') {
            $query->where('registration_type', $request->registration_type);
        }

        if ($request->has('district_id') && $request->district_id != '') {
            $query->where('district_id', $request->district_id);
        }

        if ($request->has('village_id') && $request->village_id != '') {
            $query->where('village_id', $request->village_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button onclick="approveUser('.$row->id.')" class="btn btn-success btn-sm">Approve</button>';
                $btn .= '<button onclick="rejectUser('.$row->id.')" class="btn btn-danger btn-sm">Reject</button>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('district_name', function($row) {
                return $row->district ? $row->district->name : '-';
            })
            ->addColumn('village_name', function($row) {
                return $row->village ? $row->village->name : '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Approve a user's registration
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveUser(User $user)
    {
        try {
            if ($user->registration_status !== 'Process') {
                return response()->json([
                    'message' => 'Status registrasi user tidak valid untuk disetujui'
                ], 422);
            }

            $user->update([
                'registration_status' => 'Completed',
                'email_verified_at' => now(),
            ]);

           
            // Notification::send($user, new UserApproved());

            return response()->json([
                'message' => 'User berhasil disetujui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyetujui user'
            ], 500);
        }
    }

    /**
     * Reject a user's registration
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectUser(Request $request, User $user)
    {
        try {
            if ($user->registration_status !== 'Process') {
                return response()->json([
                    'message' => 'Status registrasi user tidak valid untuk ditolak'
                ], 422);
            }

            $user->update([
                'registration_status' => 'Rejected'
            ]);

            // You might want to send an email notification here
            // Notification::send($user, new UserRejected());

            return response()->json([
                'message' => 'User berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menolak user'
            ], 500);
        }
    }

}

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
        return view('account-management.index', compact('districts', 'villages', 'users'));
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
        return view('account-management.create', compact('districts', 'villages'));
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
            'role' => 'required|in:admin,operator,user,instance',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        if ($request->input('role') === 'instance') {
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
                'district_id' => $request->role === 'instance' ? $request->district_id : null,
                'village_id' => $request->role === 'instance' ? $request->village_id : null,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'registration_status' => $request->role === 'user' ? 'Completed' : 'Process',
                'registration_type' => $request->role === 'instance' ? $request->registration_type : 'User, Perorangan',
            ]);

            return redirect()->route('admin.manajemen-akun.index')
                           ->with('success', 'Akun berhasil dibuat');
        } catch (\Exception $e) {
            return redirect()->route('admin.manajemen-akun.create')->with('error', 'Pendaftaran gagal! Silakan coba lagi.')->withInput();
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
        return view('manajemen-akun.modal_edit_akun', compact('user', 'districts', 'villages'));
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
        return redirect()->route('admin.manajemen-akun.index')->with('success', 'Akun berhasil diubah');
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

    public function verification()
    {   
        $districts = District::with('villages')->get();
        $villages = Village::all();
        $users = User::whereIn('registration_status', ['Process'])->get();
        return view('manajemen-akun.verification_table', compact('districts', 'villages', 'users'));
    }

    public function getData(Request $request)
    {
        $query = User::with(['district', 'village'])->where('role', '!=', 'admin');

        if ($request->filled('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function($q) use ($searchValue) {
                $q->whereHas('district', function($districtQuery) use ($searchValue) {
                    $districtQuery->where('name', 'like', "%{$searchValue}%");
                })
                ->orWhereHas('village', function($villageQuery) use ($searchValue) {
                    $villageQuery->where('name', 'like', "%{$searchValue}%");
                });
            });
        }

        if ($request->filled('genders')) {
            $query->whereIn('gender', explode(',', $request->genders));
        }

        if ($request->filled('types')) {
            $query->whereIn('registration_type', explode(',', $request->types));
        }

        if ($request->filled('kecamatan')) {
            $query->whereHas('district', function($q) use ($request) {
                $q->where('id', $request->kecamatan);
            });
        }

        if ($request->filled('desa')) {
            $query->whereHas('village', function($q) use ($request) {
                $q->where('id', $request->desa);
            });
        }

        if ($request->filled('time')) {
            $order = $request->time == 'Terbaru' ? 'desc' : 'asc';
            $query->orderBy('created_at', $order);
        }   

        if ($request->filled('gender')) {
            $query->whereIn('gender', explode(',', $request->gender));
        }

        if ($request->filled('rt')) {
            $query->where('rt', 'like', '%' . $request->rt . '%');
        }
        
        if ($request->filled('rw')) {
            $query->where('rw', 'like', '%' . $request->rw . '%');
        }
        
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $hashedId = $row->getHashedId();
                $actionBtn = '<div class="btn-group" role="group">';
                $actionBtn .= '<a target="_blank" href="'.route('admin.manajemen-akun.edit', $hashedId).'" class="btn btn-outline-primary" style="cursor: pointer;"><i class="bi bi-pencil-square fs-5"></i></a>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })   
            ->addColumn('district_name', function($row) {
                return $row->district ? $row->district->name : '-';
            })
            ->addColumn('village_name', function($row) {
                return $row->village ? $row->village->name : '-';
            })
            ->editColumn('birth_date', function($row) {
                return getFlatpickrDate($row->birth_date);
            })
            ->editColumn('registration_status', function($row) {
                $html = '';
                if ($row->registration_status == 'Process') {
                    $html .= '<span class="badge bg-warning mb-1">Proses Verifikasi</span>';
                } elseif ($row->registration_status == 'Rejected') {
                    $html .= '<span class="badge bg-danger mb-1">Ditolak</span>';
                } elseif ($row->registration_status == 'Completed') {
                    $html .= '<span class="badge bg-success mb-1">Terverifikasi</span>';
                } else {
                    $html .= '<span class="badge bg-secondary mb-1">-</span>';
                }
                return $html;
            })
            ->filterColumn('district', function($query, $keyword) {
                $query->whereHas('district', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('village', function($query, $keyword) {
                $query->whereHas('village', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action', 'registration_status'])
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

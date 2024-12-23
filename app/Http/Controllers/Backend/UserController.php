<?php

namespace App\Http\Controllers\Backend;
use App\Models\User;
use App\Models\Service;
use App\Models\Village;
use App\Models\District;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
        $users = User::whereIn('role', ['instance', 'user'])
                    ->whereIn('registration_status', ['Completed', 'Rejected'])
                    ->get();
        return view('account-management.index', compact('districts', 'villages', 'users'));
    }

    public function createOperator()
{
    // Ambil semua kecamatan dan status ketersediaannya
    $districts = District::select('districts.*')
        ->leftJoin('users', function($join) {
            $join->on('districts.id', '=', 'users.district_id')
                 ->where('users.role', '=', 'operator');
        })
        ->selectRaw('CASE WHEN users.id IS NULL THEN true ELSE false END as is_available')
        ->get();

    return view('account-management.create_account_operator', compact('districts'));
}

    public function checkDistrictAvailability(Request $request)
    {
        $operator = User::where('role', 'operator')
            ->where('district_id', $request->district_id)
            ->with('district')
            ->first();

        if ($operator) {
            return response()->json([
                'available' => false,
                'message' => "Kecamatan ini sudah memiliki operator: {$operator->full_name}",
                'operator' => [
                    'name' => $operator->full_name,
                    'district' => $operator->district->name
                ]
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Kecamatan tersedia'
        ]);
    }

    public function checkAllAvailability()
{
    $districts = District::all()->map(function ($district) {
        return [
            'id' => $district->id,
            'available' => !User::where('district_id', $district->id)
                              ->where('role', 'operator')
                              ->exists()
        ];
    });

    return response()->json(['districts' => $districts]);
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

    private function generate16DigitNumber() {
        $number = '';
        for ($i = 0; $i < 16; $i++) {
            $number .= mt_rand(0, 9);
        }
        return $number;
    }

    public function store(Request $request)
    {
        $rules = [
            'nik' => 'required|string|digits:16',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'username' => 'nullable|string|max:255',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'address' => 'required|string',
            'no_kk' => 'required|string|digits:16',
            'phone_number' => 'required|string|digits_between:10,14',
            'district_id'=> 'required|exists:districts,id',
            'village_id'=> 'nullable|exists:villages,id',
            'role' => 'required|in:admin,operator,user,instance',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        if($request->email != null) {
            $rules['email'] = 'email';
        } 

        if ($request->input('role') === 'instance') {
            $rules['registration_type'] = 'required|string';
            $request['nik']= $this->generate16DigitNumber();
            $request['no_kk'] = $this->generate16DigitNumber();
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
            $user = new User([
                'nik' => $request->nik,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'full_name' => $request->full_name,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'no_kk' => $request->no_kk,
                'email' => $request->email,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'phone_number' => $request->phone_number,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'address' => $request->address,
                'role' => $request->role,
                'registration_type' => in_array($request->role, ['instance', 'operator']) ? $request->registration_type : 'User, Perorangan',
                'registration_status' => in_array($request->role, ['user', 'operator']) ? 'Completed' : 'Process',
            ]);
            
            $user->save();
            
            if($request->role === 'instance') {
                $instance = Instance::where('user_id', $user->id)->first();
                if(empty($instance)) {
                    $instance = Instance::create([
                        'name' => $request->instance_name,
                        'user_id' => $user->id,
                    ]);
                } 
            }

            if ($request->input('role') != 'instance') {
                return redirect()->route('admin.manajemen-akun.index')->with('success', 'Akun berhasil dibuat');
            } else {
                return redirect()->route('admin.user.verification')->with('success', 'Akun berhasil dibuat');
            }
        } catch (\Exception $e) {
            $errorMessage = 'Pendaftaran gagal! Error pada file ' . basename($e->getFile()) . ' baris ke-' . $e->getLine();
            return redirect()
                ->route('admin.manajemen-akun.index')
                ->with('error', $errorMessage)
                ->withInput();
        }
    }
    public function storeOperator(Request $request)
    {
        // Validasi input
        $rules = [
            'username' => 'required|string|max:255|unique:users',
            'full_name' => 'required|string|max:255',
            'district_id'=> 'required|exists:districts,id',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        if($request->email) {
            $rules['email'] = 'email|unique:users,email';
        }
        if($request->phone_number) {
            $rules['phone_number'] = 'string|digits_between:10,14';
        }
        if($request->nik) {
            $rules['nik'] = 'string|digits:16';
        }
        if($request->no_kk) {
            $rules['no_kk'] = 'string|digits:16';
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', implode('<br>', $validator->errors()->all()));
        }

        try {
            // Double check district availability
            $isDistrictAvailable = !User::where('district_id', $request->district_id)
                ->where('role', 'operator')
                ->exists();

            if (!$isDistrictAvailable) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kecamatan ini sudah memiliki operator');
            }

            // Create new user
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'full_name' => $request->full_name,
                'email' => $request->email,
                'district_id' => $request->district_id,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
                'rt' => $request->rt ?? '000',
                'rw' => $request->rw ?? '000',
                'nik' => $request->nik ,
                'no_kk' => $request->no_kk,
                // 'village_id' => $request->village_id,
                'birth_date' => $request->birth_date ?? now(),
                'role' => 'operator',
                'registration_type' => 'Operator',
                'registration_status' => 'Completed',
            ]);

            return redirect()
                ->route('admin.manajemen-akun.index')
                ->with('success', 'Akun operator berhasil dibuat');

        } catch (\Exception $e) {
            \Log::error('Error creating operator account: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat akun operator: ' . $e->getMessage());
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
    public function edit($hashedId)
    {
        $districts = District::with('villages')->get();
        $villages = Village::all();
        $user = User::with('instance')->whereHash($hashedId)->first();
        return view('account-management.edit', compact('user', 'districts', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hashedId)
    {
        $user = User::whereHash($hashedId)->first();

        if (!$user) {
            return redirect()->route('admin.manajemen-akun.index')->with('error', 'User tidak ditemukan')->withInput();
        }

        try {
            $userData = [
                'nik' => $request->nik,
                'full_name' => $request->full_name,
                'username' => $request->username,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'address' => $request->address,
                'no_kk' => $request->no_kk,
                'email' => $request->email,
                'district_id' => $request->district_id,
                'village_id' =>  $request->village_id,
                'phone_number' => $request->phone_number,
                'role' => $request->role,
                'registration_status' => $request->role === 'instance' ? 'Process' : 'Completed',
                'registration_type' => $request->role === 'operator' ? 'Operator' : ($request->role === 'instance' ? $request->registration_type : 'User, Perorangan'),
            ];

            if($request->role === 'operator') {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);

            if ($request->role === 'instance') {
                $instance = Instance::where('user_id', $user->id)->first();
                if (!$instance) {
                    Instance::create([
                        'name' => $request->instance_name,
                        'user_id' => $user->id,
                    ]);
                } else {
                    Instance::where('user_id', $user->id)->update([
                        'name' => $request->instance_name,
                    ]);
                }
            }

            return redirect()->route('admin.manajemen-akun.index')->with('success', 'Data akun berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.manajemen-akun.index')->with('error', 'Perbarui data gagal! Silakan coba lagi. Error: ' . $e->getMessage())->withInput();
        }
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
        return view('account-management.verification', compact('districts', 'villages', 'users'));
    }

    public function getData(Request $request)
    {
        $adminOperator = User::select('id')->whereIn('registration_type', ['Admin', 'Operator'])->get();
        $idAdminOperator = $adminOperator->pluck('id')->toArray(); 

        $query = User::with(['district', 'village', 'services'])
            ->where('role', '!=', 'admin')
            ->whereIn('registration_status', ['Completed', 'Rejected'])
            ->whereDoesntHave('services', function ($query) use ($idAdminOperator) {
                $query->whereIn('created_by', $idAdminOperator);
            });

        if (auth()->user()->role === 'operator') {
            $query->where('district_id', auth()->user()->district_id);
        }

        $query = $this->applyFilters($query, $request);

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $hashedId = $row->getHashedId();
                return '<div class="btn-group" role="group">
                            <a target="_blank" href="' . route('admin.manajemen-akun.edit', $hashedId) . '" 
                            class="btn btn-outline-primary" style="cursor: pointer;">
                            <i class="bi bi-pencil-square fs-5"></i>
                            </a>
                        </div>';
            })
            ->addColumn('district_name', function ($row) {
                return $row->district ? $row->district->name : '-';
            })
            ->addColumn('village_name', function ($row) {
                return $row->village ? $row->village->name : '-';
            })
            ->editColumn('birth_date', function ($row) {
                return $row->birth_date ? getFlatpickrDate($row->birth_date) : '-';
            })
            ->editColumn('registration_type', function ($row) {
                $instaceName = optional($row->instance)->name ?? '';
                $html = '<div class="d-flex flex-column justify-content-center align-items-center text-center">';
                if ($row->registration_type == 'Operator') {
                    $html .= '<span class="badge bg-danger mb-1">' . strtoupper($row->registration_type) . '</span>';
                } elseif (str_contains($row->registration_type, 'Intansi')) {
                    $html .= '<a data-bs-toggle="modal" data-bs-target="#instanceModal" style="cursor: pointer;" 
                            class="badge bg-primary mb-1" data-instance_name="' . $instaceName . '">' . strtoupper($row->registration_type) . '</a>';
                } elseif ($row->registration_type == 'User') {
                    $html .= '<span class="badge bg-success mb-1">' . strtoupper($row->registration_type) . '</span>';
                } else {
                    $html .= '<span class="badge bg-secondary mb-1">-</span>';
                }
                $html .= '</div>';
                return $html;
            })
            ->editColumn('registration_status', function ($row) {
                $html = '<div class="d-flex flex-column justify-content-center align-items-center text-center">';
                if ($row->registration_status == 'Process') {
                    $html .= '<span class="badge bg-warning mb-1">Proses Verifikasi</span>';
                } elseif ($row->registration_status == 'Rejected') {
                    $html .= '<span class="badge bg-danger mb-1">Ditolak</span>';
                } elseif ($row->registration_status == 'Completed') {
                    $html .= '<span class="badge bg-success mb-1">Terverifikasi</span>';
                } else {
                    $html .= '<span class="badge bg-secondary mb-1">-</span>';
                }
                $html .= '</div>';
                return $html;
            })
            ->filterColumn('district', function ($query, $keyword) {
                $query->whereHas('district', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('village', function ($query, $keyword) {
                $query->whereHas('village', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action', 'registration_status', 'registration_type'])
            ->make(true);
    }


    public function getVerificationData(Request $request)
    {
        $query = User::with(['district', 'village'])->where('role', '!=', 'admin')->where('registration_status', 'Process');
        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';    
                $btn .= '<button onclick="rejectUser('.$row->id.')" class="btn btn-danger btn-sm">Tolak</button>';
                $btn .= '<button onclick="approveUser('.$row->id.')" class="btn btn-success btn-sm">Setujui</button>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('district_name', function($row) {
                return $row->district ? $row->district->name : '-';
            })
            ->addColumn('village_name', function($row) {
                return $row->village ? $row->village->name : '-';
            })
            ->editColumn('registration_type', function($row) {
                $instaceName = optional($row->instance)->name ?? '';
                $html = '<div class="d-flex flex-column justify-content-center align-items-center text-center">';
                if ($row->registration_type == 'Operator') {
                    $html .= '<span class="badge bg-danger mb-1">'. strtoupper($row->registration_type) .'</span>';
                } elseif (str_contains($row->registration_type, 'Intansi')) {
                    $html .= '<a data-bs-toggle="modal" data-bs-target="#instanceModal" style="cursor: pointer;" class="badge bg-primary mb-1" data-instance_name="'. $instaceName .'">'. strtoupper($row->registration_type) .'</a>';
                } elseif ($row->registration_type == 'User') {
                    $html .= '<span class="badge bg-success mb-1">'. strtoupper($row->registration_type) .'</span>';
                } else {
                    $html .= '<span class="badge bg-secondary mb-1">-</span>';
                }
                $html .= '</div>';
                return $html;
            })
            ->editColumn('registration_status', function($row) {
                $html = '<div class="d-flex flex-column justify-content-center align-items-center text-center">';
                if ($row->registration_status == 'Process') {
                    $html .= '<span class="badge bg-warning mb-1">Proses Verifikasi</span>';
                } elseif ($row->registration_status == 'Rejected') {
                    $html .= '<span class="badge bg-danger mb-1">Ditolak</span>';
                } elseif ($row->registration_status == 'Completed') {
                    $html .= '<span class="badge bg-success mb-1">Terverifikasi</span>';
                } else {
                    $html .= '<span class="badge bg-secondary mb-1">-</span>';
                }
                $html .= '</div>';
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
            ->rawColumns(['action', 'registration_status', 'registration_type'])
            ->make(true);
    }

    /**
     * Approve a user's registration
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
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
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        try {
            if ($user->registration_status !== 'Process') {
                return response()->json([
                    'message' => 'Status registrasi user tidak valid untuk ditolak'
                ], 422);
            }

            $user->update([
                'registration_status' => 'Rejected'
            ]);

            return response()->json([
                'message' => 'User berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menolak user'
            ], 500);
        }
    }

    private function applyFilters($query, $request)
    {
        if ($request->filled('genders') || $request->filled('gender')) {
            $genderFilter = $request->genders ?? $request->gender;
            $query->whereIn('gender', explode(',', $genderFilter));
        }

        if ($request->filled('types')) {
            $query->whereIn('role', explode(',', $request->types));
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

        if ($request->filled('rt')) {
            $query->where('rt', 'like', '%' . $request->rt . '%');
        }
        
        if ($request->filled('rw')) {
            $query->where('rw', 'like', '%' . $request->rw . '%');
        }

        return $query;
    }

}

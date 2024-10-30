<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Village;
use App\Models\User;
use App\Models\Instance;

use App\Http\Controllers\Controller;
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
            'phone_number' => 'required|string|digits_between:10,14',
            'district_id'=> 'required|exists:districts,id',
            'village_id'=> 'required|exists:villages,id',
            'role' => 'required|in:admin,operator,user,instance',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        if($request->email != null) {
            $rules['email'] = 'unique:users,email';
        } 

        if ($request->input('role') === 'instance') {
            $rules['registration_type'] = 'required|string';
           
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
                'district_id' => $request->district_id,
                'village_id' =>  $request->village_id,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'registration_status' => $request->role === 'user' ? 'Completed' : 'Process',
                'registration_type' => $request->role === 'instance' ? $request->registration_type : 'User, Perorangan',
            ]);

        

            if($request->role === 'instance') {
                $instance = Instance::where('user_id', $user->id)->first();
                if(empty($instance)) {
                    $instance = Instance::create([
                        'name' => $request->instance_name,
                        'user_id' => $user->id,
                    ]);
                } 
            }

            return redirect()->route('admin.manajemen-akun.index')->with('success', 'Akun berhasil dibuat');
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
            $user->update([
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
                'role' => $request->role,
                'registration_status' => $request->role === 'instance' ? 'Process' : 'Completed',
                'registration_type' => $request->role === 'instance' ? $request->registration_type : 'User, Perorangan',
            ]);

            if ($request->role === 'instance') {
                $instance = Instance::where('user_id', $user->id)->first();
                if (!$instance) {
                    Instance::create([
                        'name' => $request->instance_name,
                        'user_id' => $user->id,
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
        $query = User::with(['district', 'village'])
            ->where('role', '!=', 'admin')
            ->whereIn('registration_status', ['Completed', 'Rejected']);

        $query = $this->applyFilters($query, $request);

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

    public function getVerificationData(Request $request)
    {
        $query = User::with(['district', 'village'])->where('role', '!=', 'admin')->where('registration_status', 'Process');
        // ->where('registration_type', 'LIKE', '%Instansi%');

        $query = $this->applyFilters($query, $request);

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

    private function applyFilters($query, $request)
    {
        if ($request->filled('genders') || $request->filled('gender')) {
            $genderFilter = $request->genders ?? $request->gender;
            $query->whereIn('gender', explode(',', $genderFilter));
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

        if ($request->filled('rt')) {
            $query->where('rt', 'like', '%' . $request->rt . '%');
        }
        
        if ($request->filled('rw')) {
            $query->where('rw', 'like', '%' . $request->rw . '%');
        }

        return $query;
    }

}

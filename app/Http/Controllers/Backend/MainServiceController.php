<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use App\Models\Village;
use App\Models\District;
use App\Models\Instance;
use App\Helpers\CRUDHelper;
use App\Models\ServiceForm;
use App\Models\ServiceList;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use App\Models\InstanceUsers;
use App\Exports\ServicesExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\BadRequestHttpException;
use Illuminate\Http\Exceptions\AccessDeniedHttpException;

use PDF;

class MainServiceController extends Controller 
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Simplified auth check using the default guard
            if (!auth()->check()) {
                throw new AccessDeniedHttpException('Anda harus login terlebih dahulu');
            }

            // Store the authenticated user in a class property
            $this->currentUser = auth()->user();

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::whereNull('deleted_at')
            ->where('working_status', '!=', 'Done')
            ->whereNotIn('service_status', ['Rejected', 'Completed'])
            ->get();

        foreach ($services as $service) {
            $lateStatus = getLateWorkingStatus($service->created_at);
            if (isset($lateStatus['true'])) {
                $service->update(['working_status' => 'Late']);
            }
        }

        $districts = District::orderBy('name', 'asc')->get();   
        $villages = Village::orderBy('name', 'asc')->get();

        return view('main-service.index', compact('services', 'districts', 'villages'));
    }

    private function applyFilters($query, $request)
    {
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('time')) {
            $query->orderBy('id', $request->time);
        }        

        if ($request->filled('services')) {
            $query->whereHas('service_list', function($q) use ($request) {
                $q->whereIn('service_name', explode(',', $request->services));
            });
        }

        if ($request->filled('categories')) {
            $query->where('service_category', $request->categories);
        }

        if ($request->filled('types')) {
            $query->whereIn('service_type', explode(',', $request->types));
        }

        if ($request->filled('kecamatan')) {
            $query->whereHas('user.district', function($q) use ($request) {
                $q->where('id', $request->kecamatan);
            });
        }

        if ($request->filled('desa')) {
            $query->whereHas('user.village', function($q) use ($request) {
                $q->where('id', $request->desa);
            });
        }

        if ($request->filled('service_statuses')) {
            if(str_contains($request->service_statuses, 'Not Yet')) { 
                $request->service_statuses .= ',-';
            }
            $query->whereIn('service_status', explode(',', $request->service_statuses));
        }

        if ($request->filled('work_statuses')) {
            if(str_contains($request->work_statuses, 'Not Yet')) { 
                $request->work_statuses .= ',-';
            }
            $query->whereIn('working_status', explode(',', $request->work_statuses));
        }

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function cekNIK(Request $request) 
    {
        $user = User::where('nik', $request->nik)->first();
        return response()->json(!empty($user) ? true : false);
    }

    public function getData(Request $request)
    {
        $query = Service::with(['user', 'user.district', 'user.village', 'user.instance', 'user.instance.instanceUsers'])
                ->orderByRaw("
                    CASE 
                        WHEN working_status = 'Late' THEN 1
                        WHEN working_status = 'Not Yet' THEN 2
                        WHEN working_status = 'Process' THEN 3
                        ELSE 4
                    END
                ");

        if ($request->filled('page') && $request->page == 'report') {
            $query->orderBy('created_at', 'ASC');
        }

        if (auth()->user()->role == 'instance') {
            $instance = Instance::where('user_id', auth()->user()->id)->first();
            $instanceUsers = $instance->instanceUsers;
            $query->whereIn('user_id', $instanceUsers->pluck('user_id'));
        }

        if (auth()->user()->role == 'operator') {
            $query->whereHas('user', function($q) {
                $q->where('district_id', auth()->user()->district_id);
            });
        }

        if (auth()->user()->role == 'user') {
            $query->where('user_id', auth()->user()->id);
        }

        if ($request->filled('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function($q) use ($searchValue) {
                $q->where('services.service_category', 'like', "%{$searchValue}%")
                    ->orWhere('services.service_type', 'like', "%{$searchValue}%")
                    ->orWhere('services.reason', 'like', "%{$searchValue}%")
                    ->orWhereHas('user', function($userQuery) use ($searchValue) {
                        $userQuery->where('full_name', 'like', "%{$searchValue}%")
                                    ->orWhere('address', 'like', "%{$searchValue}%")
                                    ->orWhere('phone_number', 'like', "%{$searchValue}%");
                    })
                    ->orWhereHas('user.district', function($districtQuery) use ($searchValue) {
                        $districtQuery->where('name', 'like', "%{$searchValue}%");
                    })
                    ->orWhereHas('user.village', function($villageQuery) use ($searchValue) {
                        $villageQuery->where('name', 'like', "%{$searchValue}%");
                    })
                    ->orWhereHas('service_list', function($serviceListQuery) use ($searchValue) {
                        $serviceListQuery->where('service_name', 'like', "%{$searchValue}%");
                    });
            });
        }
        $query = $this->applyFilters($query, $request);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $hashedId = $row->getHashedId();
                $approvalName = optional($row->approvalBy)->full_name ?? 'Data tidak ada';
                $actionBtn = '<div class="btn-group" role="group">';

                if (auth()->user()->role == 'admin' || auth()->user()->role == 'operator') {
                    $actionBtn .= '<a target="_blank" href="'.route(auth()->user()->role .'.pelayanan.edit', $hashedId).'" class="btn btn-outline-primary" style="cursor: pointer;"><i class="bi bi-pencil-square fs-5"></i></a>';
                }

                if((auth()->user()->role == 'user' || auth()->user()->role == 'instance') && $row->service_status == 'Rejected') {
                    $actionBtn .= '<a target="_blank" href="'. route(auth()->user()->role .'.pelayanan.edit', $hashedId).'" class="btn btn-outline-primary" style="cursor: pointer;"><i class="bi bi-pencil-square fs-5"></i></a>';
                }

                $actionBtn .= '<a class="btn btn-outline-success delete-btn" data-bs-toggle="modal" 
                                                                        data-bs-target="#confirmationModal" 
                                                                        data-id="'.$hashedId.'" 
                                                                        data-reason="'. $row->rejected_reason .'" 
                                                                        data-approval_by="'. $approvalName.'" 
                                                                        data-service_status="'. $row->service_status .'"
                                                                        data-visit_schedule="'. $row->visit_schedule .'" 
                                                                        data-working_status="'. $row->working_status .'"
                                                                        data-message_for_user="'. $row->message_for_user .'" 
                                                                        data-document_recieved_status="'. $row->document_recieved_status .'"
                                                                        style="cursor: pointer;"><i class="bi bi-person-check fs-5"></i></a>';

                if(auth()->user()->role != 'user' && auth()->user()->role != 'instance' && $row->service_status != 'Not Yet') {
                    $actionBtn .= '<a class="btn btn-outline-primary" data-bs-toggle="modal" 
                                                                        data-bs-target="#workingStatusModal" 
                                                                        data-id="'.$hashedId.'" 
                                                                        data-working_status="'. $row->working_status .'"
                                                                        data-message="'. $row->message_for_user .'"
                                                                        style="cursor: pointer;"><i class="bi bi-clipboard-check fs-5"></i></i></a>';
                }                                                                   
                $actionBtn .= '</div>';
                return $actionBtn;
            })            
            ->addColumn('name', function($row) {
                $html = $row->user->full_name;
                $html .= '<small class="badge text-primary" style="margin-left: -10px;">Pemohon : ' . $row->createdBy->full_name . '</small>'; 
                return $html;
            })
            ->addColumn('service', function($row) {
                return $row->service_list->service_name;
            })
            ->addColumn('tanggal', function($row) {
                return getFlatpickrDate(date('Y-m-d', strtotime($row->created_at)));
            })
            ->addColumn('birth_date', function($row) {
                return getFlatpickrDate($row->user->birth_date);
            })
            ->addColumn('address', function($row) {
                return $row->user->address;
            })
            ->addColumn('rt', function($row) {
                return $row->user->rt;
            })
            ->addColumn('rw', function($row) {
                return $row->user->rw;
            })
            ->addColumn('district', function($row) {
                return optional($row->user->district)->name ?? '-';
            })
            ->addColumn('village', function($row) {
                return optional($row->user->village)->name ?? '-';
            })
            ->addColumn('phone_number', function($row) {
                return $row->user->phone_number;
            })
            ->addColumn('evidence_of_disability_image', function($row) {
                $evidence = $row->service_image()->where('image_type', 'Bukti Keterbatasan')->first();
                $evidence_odgj = $row->service_image()->where('image_type', 'Bukti Keterbatasan ODGJ')->first();
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"  
                        data-title="Foto Bukti Keterbatasan" 
                        data-image="' . (isset($evidence->image_path) ? $evidence->image_path : '-') . '"
                        data-image_name="' . (isset($evidence->original_name) ? $evidence->original_name : '-') . '"
                        data-image_created_at="' . (isset($evidence->created_at) ? getFlatpickrDate($evidence->created_at) : '-') . '"
                        data-odgj_image="' . (isset($evidence_odgj->image_path) ? $evidence_odgj->image_path : '-') . '"
                        data-odgj_image_name="' . (isset($evidence_odgj->original_name) ? $evidence_odgj->original_name : '-') . '"
                        data-odgj_image_created_at="' . (isset($evidence_odgj->created_at) ? getFlatpickrDate($evidence_odgj->created_at) : '-') . '">Lihat Foto</a>';
            })
            ->addColumn('ktp_image', function($row) {
                $ktp = $row->service_image()->where('image_type', 'KTP')->first();
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" 
                        data-title="Foto KTP"  
                        data-image="' . (isset($ktp->image_path) ? $ktp->image_path : '-') . '"
                        data-image_name="' . (isset($ktp->original_name) ? $ktp->original_name : '-') . '"
                        data-image_created_at="' . (isset($ktp->created_at) ? getFlatpickrDate($ktp->created_at) : '-') . '">Lihat Foto</a>';
            })
            ->addColumn('kk_image', function($row) {
                $kk = $row->service_image()->where('image_type', 'Kartu Keluarga')->first();
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" 
                        data-title="Foto Kartu Keluarga"  
                        data-image="' . (isset($kk->image_path) ? $kk->image_path : '-') . '"
                        data-image_name="' . (isset($kk->original_name) ? $kk->original_name : '-') . '"
                        data-image_created_at="' . (isset($kk->created_at) ? getFlatpickrDate($kk->created_at) : '-') . '">Lihat Foto</a>';
            })
            ->addColumn('formulir', function($row) {
                $f101 = $row->service_form()->where('form_type', 'F1.01')->first();
                $f102 = $row->service_form()->where('form_type', 'F1.02')->first();
                $f103 = $row->service_form()->where('form_type', 'F1.03')->first();
                $f104 = $row->service_form()->where('form_type', 'F1.04')->first();
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#formulirDownloadModal"
                        data-title="Formulir" 
                        data-imagef101="' . (isset($f101->form_path) ? $f101->form_path : '-') . '"
                        data-imagef102="' . (isset($f102->form_path) ? $f102->form_path : '-') . '"
                        data-imagef103="' . (isset($f103->form_path) ? $f103->form_path : '-') . '"
                        data-imagef104="' . (isset($f104->form_path) ? $f104->form_path : '-') . '">Lihat Form</a>';
            })
            ->addColumn('working_status', function($row) {
                switch($row->working_status) {
                    case 'Not Yet':
                        return '<div class="d-flex justify-content-center"><span class="badge bg-secondary">Menunggu</span></div>';
                    case 'Late':
                        $lateStatus = getLateWorkingStatus($row->created_at);
                        if (isset($lateStatus['true'])) {
                            return '<div class="d-flex justify-content-center"><span class="badge bg-danger">'. $lateStatus['true'] . '</span></div>';
                        } else {
                            return '<div class="d-flex justify-content-center"><span class="badge bg-danger">Terlambat</span></div>';
                        }
                    case 'Process':
                        return '<div class="d-flex justify-content-center"><span class="badge bg-warning">Proses</span></div>';
                    case 'Done':
                        return '<div class="d-flex justify-content-center"><span class="badge bg-success">Selesai</span></div>';
                    default:
                        return '<div class="d-flex justify-content-center"><span class="badge bg-secondary">'. $row->working_status .'</span></div>';
                }
            })
            ->addColumn('service_status', function($row) {
                $html = '<div class="d-flex flex-column align-items-center">';
            
                if ($row->service_status == 'Not Yet') {
                    $html .= '<span class="badge bg-secondary mb-1">Belum Dikerjakan</span>';
                } elseif ($row->service_status == 'Process') {
                    $html .= '<span class="badge bg-warning mb-1">Proses</span>';
                } elseif ($row->service_status == 'Rejected') {
                    $html .= '<span class="badge bg-danger mb-1">Ditolak</span>';
                } elseif ($row->service_status == 'Completed') {
                    $html .= '<span class="badge bg-success mb-1">Selesai</span>';
                } else {
                    $html .= '<span class="badge bg-secondary mb-1">-</span>';
                }
            
                if($row->rejected_reason == null) {
                    if ($row->document_recieved_status == 'Not Yet Recieved') {
                        $html .= '<span class="badge bg-danger">Dokumen Belum</span>';
                    } else {
                        $html .= '<span class="badge bg-success">Dokumen Sudah</span>';
                    }
                }
            
                $html .= '</div>';
                return $html;
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->whereHas('user', function($q) use ($keyword) {
                    $q->where('full_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('address', function($query, $keyword) {
                $query->whereHas('user', function($q) use ($keyword) {
                    $q->where('address', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('village', function($query, $keyword) {
                $query->whereHas('user.phone_number', function($q) use ($keyword) {
                    $q->where('phone_number', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('district', function($query, $keyword) {
                $query->whereHas('user.district', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('village', function($query, $keyword) {
                $query->whereHas('user.village', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action', 'name', 'tanggal', 'birth_date', 'alamat', 'rt', 'rw', 'district', 'village', 'phone_number', 'evidence_of_disability_image', 'ktp_image', 'kk_image', 'formulir', 'working_status', 'service_status'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $data['pelayanan'] = $request->pelayanan;
        $data['tipe_layanan'] = $request->tipe_layanan;
        $data['districts'] = District::orderBy('name', 'asc')->get();
        return view('main-service.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        set_time_limit(0);
        try {
            $request->nik = str_replace(' ', '', $request->nik);
            $userData = [
                'nik' => $request->nik,
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'registration_type' => 'User',
                'registration_status' => 'Completed',
                'role' => 'user'
            ];

            if(auth()->user()->role == 'user'){
                $user = User::find(auth()->user()->id);
                $user->update($userData);
            } elseif(auth()->user()->role == 'instance') {
                $userData['password'] = bcrypt($request->nik);
                $user = User::create($userData);
                $instance = Instance::where('user_id', auth()->user()->id)->first();
                if(!$instance) { 
                    $instance = new Instance();
                    $instance->name = 'Yayasan ' . auth()->user()->full_name;
                    $instance->user_id = auth()->user()->id;
                    $instance->save();
                } else {
                    InstanceUsers::create([
                        'instance_id' => $instance->id,
                        'user_id' => $user->id,
                    ]);
                }
            } else {
                $userData['password'] = bcrypt($request->nik);
                $user = User::create($userData);
            }
            
            $service_list = ServiceList::where('service_name', $request->service)->first();
            $service = new Service();  
            $service->user_id = $user->id;
            $service->created_by = auth()->user()->id;
            $service->service_list_id = $service_list->id;
            $service->service_type = $request->service_type;
            $service->service_category = $request->service_category;
            $service->latitude = $request->latitude ?? '-';
            $service->longitude = $request->longitude ?? '-';
            $service->reason = $request->reason;
            $service->save();

            // IMAGE
            $imageTypes = [
                'ktp_image' => ['folder' => 'ktp', 'type' => 'KTP'],
                'kk_image' => ['folder' => 'kk', 'type' => 'Kartu Keluarga'],
                'evidence_of_disability_image' => ['folder' => 'evidence_of_disability', 'type' => 'Bukti Keterbatasan'],
                'evidence_of_disability_odgj_image' => ['folder' => 'evidence_of_disability_odgj', 'type' => 'Bukti Keterbatasan ODGJ', 'useFormImage' => true]
            ];

            foreach ($imageTypes as $inputName => $imageInfo) {
                if ($request->hasFile($inputName)) {
                    $imageData = CRUDHelper::processAndStoreImage(
                        $request->file($inputName),
                        $imageInfo['folder'],
                        $imageInfo['type']
                    );

                    ServiceImage::create([
                        'service_id' => $service->id,
                        'image_type' => $imageData['image_type'],
                        'image_path' => $imageData['image_path'],
                        'original_name' => $imageData['original_name']
                    ]);
                }
            }

            // FORM
            $formTypes = ['f101' => 'F1.01', 'f102' => 'F1.02', 'f103' => 'F1.03', 'f104' => 'F1.04'];

            foreach ($formTypes as $inputName => $formType) {
                if ($request->hasFile($inputName . '_file')) {
                    $formData = CRUDHelper::processAndStoreFormImage($request->file($inputName . '_file'), $inputName, $formType, $service->user->full_name);

                    ServiceForm::create([
                        'service_id' => $service->id,
                        'form_type' => $formData['form_type'],
                        'form_path' => $formData['form_path'],
                    ]);
                }
            }

            // $notifications = new Notification();
            // $notifications->user_id = auth()->user()->id;
            // $notifications->action = 'CREATE';
            // $notifications->title = 'Pengajuan ' . $request->pelayanan;
            // $notifications->body = 'Pengajuan ' . $request->pelayanan . ' baru telah diajukan';
            // $notifications->save();

            return redirectByRole(auth()->user()->role, 'pelayanan.index', ['success' => 'Pengajuan ' . ($request->service) . ' baru berhasil dibuat!']);
        } catch (\Exception $e) {
            return redirect()->route(auth()->user()->role . '.pelayanan.index')
                    ->with([
                        'error' => 'Error pada baris ' . $e->getLine() . ': ' . $e->getMessage()
                    ]);
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
        $service = Service::with(['user', 'service_image', 'service_form', 'user.district', 'user.village'])
                            ->whereHash($hashedId)
                            ->first();

        if (!$service) {
            return redirectByRole(auth()->user()->role, 'pelayanan.index', ['error' => 'Data Pelayanan Tidak Ditemukan']);
        }

        if (!$service) {
            return redirectByRole(auth()->user()->role, 'pelayanan.index', ['error' => 'Data Pelayanan Tidak Ditemukan']);
        }
        
        $service_list = ServiceList::where('id', $service->service_list_id)->first();
        $pelayanan = $service_list->service_name;
        $districts = District::orderBy('name', 'asc')->get();

        $edit_type = request('edittype') ?? '';
        return view('main-service.edit', compact('edit_type', 'service', 'pelayanan', 'districts'));
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
        try {
            $service = Service::whereHash($hashedId)->firstOrFail();
            $user = $service->user;

            $userData = [
                'nik' => $request->nik,
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'rt' => $request->rt,
                'rw' => $request->rw,
            ];

            $user->update($userData);

            $updateService = $request->only(['reason', 'service_type', 'service_category', 'latitude', 'longitude']);
            if ($request->edit_type == 'ajukan') {
                $updateService = array_merge($updateService, [
                    'working_status' => 'Not Yet',
                    'service_status' => 'Not Yet',
                    'message_for_user' => null,
                    'approval_by' => null,
                    'rejected_reason' => null
                ]);
            }

            $service->update($updateService);

            // IMAGE
            $imageTypes = [
                'ktp_image' => ['folder' => 'ktp', 'type' => 'KTP'],
                'kk_image' => ['folder' => 'kk', 'type' => 'Kartu Keluarga'],
                'evidence_of_disability_image' => ['folder' => 'evidence_of_disability', 'type' => 'Bukti Keterbatasan'],
                'evidence_of_disability_odgj_image' => ['folder' => 'evidence_of_disability_odgj', 'type' => 'Bukti Keterbatasan ODGJ', 'useFormImage' => true]
            ];

            foreach ($imageTypes as $inputName => $imageInfo) {
                $oldImage = $service->service_image()->where('image_type', $imageInfo['type'])->first();
                
                if ($request->hasFile($inputName) && $oldImage) {
                    $oldImagePath = $oldImage->image_path;

                    $imageData = CRUDHelper::processAndStoreImage(
                        $request->file($inputName),
                        $imageInfo['folder'],
                        $imageInfo['type'],
                        $oldImagePath
                    );

                    $oldImage->update([
                        'image_path' => $imageData['image_path'],
                        'original_name' => $imageData['original_name']
                    ]);
                } elseif ($request->hasFile($inputName)) {
                    $imageData = CRUDHelper::processAndStoreImage(
                        $request->file($inputName),
                        $imageInfo['folder'],
                        $imageInfo['type']
                    );

                    ServiceImage::create([
                        'service_id' => $service->id,
                        'image_type' => $imageData['image_type'],
                        'image_path' => $imageData['image_path'],
                        'original_name' => $imageData['original_name']
                    ]);
                }
            }

            // FORM
            $formTypes = ['f101' => 'F1.01', 'f102' => 'F1.02', 'f103' => 'F1.03', 'f104' => 'F1.04'];

            foreach ($formTypes as $inputName => $formType) {
                $oldForm = $service->service_form()->where('form_type', $formType)->first();
                
                if ($request->hasFile($inputName . '_file') && $oldForm) {
                    $oldFormPath = $oldForm->form_path;

                    $formData = CRUDHelper::processAndStoreFormImage(
                        $request->file($inputName . '_file'),
                        $inputName,
                        $formType,
                        $service->user->full_name,
                        $oldFormPath
                    );

                    $oldForm->update([
                        'form_path' => $formData['form_path']
                    ]);
                } elseif ($request->hasFile($inputName . '_file')) {
                    $formData = CRUDHelper::processAndStoreFormImage(
                        $request->file($inputName . '_file'),
                        $inputName,
                        $formType,
                        $service->user->full_name
                    );

                    ServiceForm::create([
                        'service_id' => $service->id,
                        'form_type' => $formData['form_type'],
                        'form_path' => $formData['form_path'],
                    ]);
                }
            }

            $notifications = new Notification();
            $notifications->user_id = auth()->user()->id;
            $notifications->action = 'UPDATE';
            $notifications->title = 'Pembaruan ' . $request->pelayanan;
            $notifications->body = 'Pengajuan ' . $request->pelayanan . ' telah diperbarui';
            $notifications->save();

            return redirectByRole(auth()->user()->role, 'pelayanan.index', ['success' => 'Pengajuan ' . ($request->service) . ' berhasil diperbarui!']);
        } catch (\Exception $e) {
            return redirectByRole(auth()->user()->role, 'pelayanan.edit', $hashedId)
                ->withInput()
                ->with([
                    // 'error' => 'Gagal memperbarui pengajuan. Error pada baris ' . $e->getLine() . ': ' . $e->getMessage(),
                    'error' => $e->getMessage(),
                    'pelayanan' => $request->service,
                    'tipe_layanan' => $request->service_type
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $hashedId)
    {
        $service = Service::whereHash($hashedId)->firstOrFail();
        if ($service) { 
            if($request->status == 'approved') {  
                $service->update([
                    'service_status' => 'Process',
                    'working_status' => 'Process',
                    'visit_schedule' => $request->visit_schedule,
                    'rejected_reason' => null,
                    'approval_by' => auth()->user()->id
                ]);
                return redirectByRole(auth()->user()->role, 'pelayanan.index', ['success' => 'Pengajuan ' . ($service->service_list->service_name) . ' diterima!']);
            } else {
                $service->update([
                    'service_status' => 'Rejected',
                    'working_status' => '-',
                    'visit_schedule' => null,
                    'rejected_reason' => $request->rejected_reason,
                    'approval_by' => auth()->user()->id
                ]);
                return redirectByRole(auth()->user()->role, 'pelayanan.index', ['success' => 'Pengajuan ' . ($service->service_list->service_name) . ' ditolak!']);
            }
        } else {
            return redirectByRole(auth()->user()->role, 'pelayanan.index', ['error' => 'Data Pelayanan Tidak Ditemukan']);
        }
    }

    public function updateVisitSchedule(Request $request, $hashedId) {
        $service = Service::whereHash($hashedId)->firstOrFail();
        if($service) {
            $service->update(['visit_schedule' => $request->visit_schedule]);
            $service->update();
            return response()->json(['success' => 'Jadwal kunjungan berhasil diperbarui!']);
        } else {
            return response()->json(['success' => 'Jadwal kunjungan gagal diperbarui']);
        }
    }

    public function workingStatus(Request $request, $hashedId) 
    {
        $service = Service::whereHash($hashedId)->firstOrFail();
        if($service) {
            $payloadWorkingStatus = [
                'working_status' => 'Done',
                // 'service_status' => 'Completed',
                'message_for_user' => $request->message_for_user
            ];

            if($request->user_type == 'Non Member') {
                $payloadWorkingStatus['service_status'] = 'Completed';
                $payloadWorkingStatus['document_recieved_status'] = 'Recieved';
            }

            $service->update($payloadWorkingStatus);

            return response()->json(['success' => 'Pengajuan ' . ($service->service_list->service_name) . ' Informasi Status Pengerjaan berhasil diperbarui!']);
            // return redirectByRole(auth()->user()->role, 'pelayanan.index', ['success' => 'Informasi Status Pengerjaan berhasil diperbarui!']);
        }  else {
            return response()->json(['error' => 'Data Pelayanan Tidak Ditemukan']);
            // return redirectByRole(auth()->user()->role, 'pelayanan.index', ['error' => 'Data Pelayanan Tidak Ditemukan']);
        }
    }

    public function documentConfirmation(Request $request)
    {
        $service = Service::whereHash($request->id)->firstOrFail();
        if($service) {
            $service->update([
                'document_recieved_status' => $request->document_recieved_status,
                'service_status' => 'Completed'
            ]);

            return response()->json(['success' => 'Status Dokumen ' . ($service->service_list->service_name) . ' berhasil diperbarui!']);
        }  else {
            return response()->json(['error' => 'Data Pelayanan Tidak Ditemukan']);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $query = Service::with(['user', 'user.district', 'user.village', 'service_image'])
                    ->orderByRaw("
                        CASE 
                            WHEN working_status = 'Late' THEN 1
                            WHEN working_status = 'Not Yet' THEN 2
                            WHEN working_status = 'Process' THEN 3
                            ELSE 4
                        END
                    ");

            if (auth()->user()->role == 'operator') {
                $query->whereHas('user', function($q) {
                    $q->where('district_id', auth()->user()->district_id);
                });
            }

            if ($request->filled('search')) {
                $searchValue = $request->search;
                $query->where(function($q) use ($searchValue) {
                    $q->where('services.service_category', 'like', "%{$searchValue}%")
                        ->orWhere('services.service_type', 'like', "%{$searchValue}%")
                        ->orWhereHas('user', function($userQuery) use ($searchValue) {
                            $userQuery->where('full_name', 'like', "%{$searchValue}%");
                        });
                });
            }

            $query = $this->applyFilters($query, $request);
            $services = $query->get();
            
            $startDate = $request->filled('start_date') ? getFlatpickrDate($request->start_date) : null;
            $endDate = $request->filled('end_date') ? getFlatpickrDate($request->end_date) : null;

            // . str_replace(' ', '_', getFlatpickrDate(date('Y-m-d'))) .
            $filename = 'Laporan_Pelayanan_' . date('d-m-Y', strtotime($request->start_date)) . '_' . date('d-m-Y', strtotime($request->end_date)) . '.xlsx';

            return Excel::download(new ServicesExport($services, $startDate, $endDate), $filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function exportPDF(Request $request) 
    {
        try {
            $query = Service::with(['user', 'user.district', 'user.village', 'service_image', 'service_list'])
                    ->orderByRaw("
                        CASE 
                            WHEN working_status = 'Late' THEN 1
                            WHEN working_status = 'Not Yet' THEN 2
                            WHEN working_status = 'Process' THEN 3
                            ELSE 4
                        END
                    ");
            
            if (auth()->user()->role == 'operator') {
                $query->whereHas('user', function($q) {
                    $q->where('district_id', auth()->user()->district_id);
                });
            }

            if ($request->filled('search')) {
                $searchValue = $request->search;
                $query->where(function($q) use ($searchValue) {
                    $q->where('services.service_category', 'like', "%{$searchValue}%")
                        ->orWhere('services.service_type', 'like', "%{$searchValue}%")
                        ->orWhereHas('user', function($userQuery) use ($searchValue) {
                            $userQuery->where('full_name', 'like', "%{$searchValue}%");
                        });
                });
            }

            $query = $this->applyFilters($query, $request);
            $services = $query->get();
            
            $startDate = $request->filled('start_date') ? getFlatpickrDate($request->start_date) : null;
            $endDate = $request->filled('end_date') ? getFlatpickrDate($request->end_date) : null;

            $pdf = PDF::loadView('exports.pdf.services-pdf', [
                'services' => $services,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

            $pdf->setPaper($request->paper, $request->orientation);
            
            $pdf->setOption([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // $getDate = str_replace(' ', '_', getFlatpickrDate(date('Y-m-d')));
            $filename = 'Laporan_Pelayanan_' . ucfirst($request->paper) . '_' . ucfirst($request->orientation) . '_' .  date('d-m-Y', strtotime($request->start_date)) . '_' . date('d-m-Y', strtotime($request->end_date)) . '.pdf';
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

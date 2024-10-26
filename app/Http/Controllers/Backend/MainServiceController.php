<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use App\Models\District;
use App\Helpers\CRUDHelper;
use App\Models\ServiceForm;
use App\Models\ServiceList;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class MainServiceController extends Controller 
{
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

        return view('main-service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData(Request $request)
    {
        $query = Service::query();

        $start_date = Carbon::parse($request->start_date)->toDateString();
        $end_date = Carbon::parse($request->end_date)->toDateString();
        
        $query->whereDate('created_at', '>=', $start_date)
              ->whereDate('created_at', '<=', $end_date);

        if ($request->has('time')) {
            if ($request->time == 'Terbaru') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->time == 'Terlama') {
                $query->orderBy('created_at', 'asc');
            }
        }

        return DataTables::of($query->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $hashedId = $row->getHashedId();
                $actionBtn = '<a href="'.route('admin.pelayanan.edit', $hashedId).'" style="cursor: pointer;">✏️</a> ';
                $actionBtn .= '<span class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModalService" data-id="'.$hashedId.'" style="cursor: pointer;">🗑️</span>';
                return $actionBtn;
            })
            ->addColumn('name', function($row) {
                return $row->user->full_name;
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
                return $row->user->district->name;
            })
            ->addColumn('village', function($row) {
                return $row->user->village->name;
            })
            ->addColumn('phone_number', function($row) {
                return $row->user->phone_number;
            })
            ->addColumn('evidence_of_disability_image', function($row) {
                $evidence = $row->service_image()->where('image_type', 'Bukti Keterbatasan')->first();
                $evidence_odgj = $row->service_image()->where('image_type', 'Bukti Keterbatasan ODGJ')->first();
                $evidence_path = isset($evidence->image_path) ? $evidence->image_path : '-';
                $evidence_odgj_path = isset($evidence_odgj->image_path) ? $evidence_odgj->image_path : '-';
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" 
                        data-image="'. $evidence_path. '"
                        data-odgj_image="'. $evidence_odgj_path. '">Lihat Foto</a>';
            })
            ->addColumn('ktp_image', function($row) {
                $ktp = $row->service_image()->where('image_type', 'KTP')->first();
                $path = isset($ktp->image_path) ? $ktp->image_path : '-';
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" 
                        data-image="'. $path. '">Lihat Foto</a>';
            })
            ->addColumn('kk_image', function($row) {
                $kk = $row->service_image()->where('image_type', 'Kartu Keluarga')->first();
                $path = isset($kk->image_path) ? $kk->image_path : '-';
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" 
                        data-image="'. $path. '">Lihat Foto</a>';
            })
            ->addColumn('formulir', function($row) {
                $f101 = $row->service_form()->where('form_type', 'F1.01')->first();
                $f102 = $row->service_form()->where('form_type', 'F1.02')->first();
                $f103 = $row->service_form()->where('form_type', 'F1.03')->first();
                $f104 = $row->service_form()->where('form_type', 'F1.04')->first();
                $f101_path = isset($f101->form_path) ? $f101->form_path : '-';
                $f102_path = isset($f102->form_path) ? $f102->form_path : '-';
                $f103_path = isset($f103->form_path) ? $f103->form_path : '-';
                $f104_path = isset($f104->form_path) ? $f104->form_path : '-';
                return '<a href="#" data-bs-toggle="modal" data-bs-target="#formModal" 
                        data-formf101="'. $f101_path. '"
                        data-formf102="'. $f102_path. '"
                        data-formf103="'. $f103_path. '"
                        data-formf104="'. $f104_path. '">Lihat Form</a>';
            })
            ->addColumn('working_status', function($row) {
                switch($row->working_status) {
                    case 'Process':
                        return '<span class="badge bg-warning">Proses</span>';
                    case 'Late':
                        $lateStatus = getLateWorkingStatus($row->created_at);
                        if (isset($lateStatus['true'])) {
                            return '<span class="badge bg-danger">'. $lateStatus['true'] . '</span>';
                        } else {
                            return '<span class="badge bg-danger">Terlambat</span>';
                        }
                    case 'Done':
                        return '<span class="badge bg-success">Selesai</span>';
                    default:
                        return '<span class="badge bg-secondary">'. $row->working_status .'</span>';
                }
            })
            ->addColumn('service_status', function($row) {
                if($row->service_status == 'Process'){
                    return '<span class="badge bg-warning">Proses</span>';
                } else if($row->working_status == 'Rejected') {
                    return '<span class="badge bg-danger">Ditolak</span>';
                } else if($row->service_status == 'Completed') {
                    return '<span class="badge bg-success">Selesai</span>';
                }
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
        try {
            $userData = [
                'nik' => $request->nik,
                'full_name' => $request->full_name,
                'password' => bcrypt($request->full_name . '12345'),
                'phone_number' => $request->phone_number,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'registration_type' => 'User',
                'registration_status' => 'Completed'
            ];

            if(auth()->user()->role == 'user'){
                $user = User::find(auth()->user()->id);
                $user->update($userData);
            } else {
                $user = User::create($userData);
            }
            
            $service_list = ServiceList::where('service_name', $request->service)->first();
            $service = new Service();  
            $service->user_id = auth()->user()->id;
            $service->service_list_id = $service_list->id;
            $service->service_type = $request->service_type;
            $service->service_category = $request->service_category;
            $service->latitude = $request->latitude;
            $service->longitude = $request->longitude;
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
                    $formData = CRUDHelper::processAndStoreFormImage($request->file($inputName . '_file'), $inputName, $formType);

                    ServiceForm::create([
                        'service_id' => $service->id,
                        'form_type' => $formData['form_type'],
                        'form_path' => $formData['form_path'],
                    ]);
                }
            }

            $notifications = new Notification();
            $notifications->user_id = auth()->user()->id;
            $notifications->action = 'CREATE';
            $notifications->title = 'Pengajuan ' . $request->pelayanan;
            $notifications->body = 'Pengajuan ' . $request->pelayanan . ' baru telah diajukan';
            $notifications->save();

            return redirectByRole(auth()->user()->role, 'pelayanan.index', ['success' => 'Pengajuan ' . ($request->service) . ' baru berhasil dibuat!']);
        } catch (\Exception $e) {
            return redirect()->route('admin.pelayanan.create')
                ->withInput()
                ->with([
                    'error' => 'Gagal menyimpan pengajuan. Error pada baris ' . $e->getLine() . ': ' . $e->getMessage(),
                    'pelayanan' => $request->service,
                    'tipe_layanan' => $request->service_type
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
    public function edit($id)
    {
        //
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
        //
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
}

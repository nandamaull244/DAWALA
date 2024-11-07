<?php

namespace App\Http\Controllers\Backend;

use App\Models\Service;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->user()->role == 'admin') {
            $data = $this->dashboardAdmin();
            return view("Dashboard.dashboard_admin")->with([
                'data' => $data
            ]);
        } elseif (auth()->user()->role == 'operator') {
            $data = $this->dashboardOperator();
            return view("Dashboard.dashboard_operator")->with([
                'data' => $data
            ]);
        } elseif (auth()->user()->role == 'instance') {
            return redirect()->route('instance.pelayanan.index');
        } else {
            return redirect()->route('user.pelayanan.index');
        }
    }

    private function dashboardAdmin() {
        $baseQuery = Service::query();
        $data['incoming_visit'] = (clone $baseQuery)->where('service_status', '=', 'Not Yet')->count();
        $data['process_visit'] = (clone $baseQuery)->where('service_status', '=', 'Process')->where('working_status', '=', 'Process')->where('document_recieved_status', '=', 'Not Yet Recieved')->count();
        $data['visit_scheduled'] = (clone $baseQuery)->whereNotNull('visit_schedule')->where('service_status', '=', 'Process')->where('working_status', '=', 'Process')->where('document_recieved_status', '=', 'Not Yet Recieved')->count();
        $data['document_recieved_visit'] = (clone $baseQuery)->where('document_recieved_status', '=', 'Not Yet Recieved')->where('working_status', '=', 'Done')->where('service_status', '=', 'Process')->count();
        $data['completed_visit'] = (clone $baseQuery)->where('service_status', '=', 'Completed')->where('document_recieved_status', '=', 'Recieved')->count();

        $data['by_district_not_yet'] = District::select('districts.name')
            ->selectRaw('COUNT(DISTINCT services.id) as total')
            ->leftJoin('users', 'districts.id', '=', 'users.district_id')
            ->leftJoin('services', 'users.id', '=', 'services.user_id')
            ->where('services.service_status', '=', 'Not Yet')
            ->where('services.working_status', '=', 'Not Yet')
            ->where('services.document_recieved_status', '=', 'Not Yet Recieved')
            ->whereNull('services.deleted_at')
            ->groupBy('districts.id', 'districts.name')
            ->orderBy('districts.name', 'asc')
            ->having('total', '>', 0)
            ->get()
            ->map(function($district) {
                return (object) [
                    'name' => $district->name,
                    'total' => $district->total
                ];
            });

        $data['by_district_completed'] = District::select('districts.name')
            ->selectRaw('COUNT(DISTINCT services.id) as total')
            ->leftJoin('users', 'districts.id', '=', 'users.district_id')
            ->leftJoin('services', 'users.id', '=', 'services.user_id')
            ->where('services.service_status', '=', 'Completed')
            ->where('services.working_status', '=', 'Done')
            ->where('services.document_recieved_status', '=', 'Recieved')
            ->whereNull('services.deleted_at')
            ->groupBy('districts.id', 'districts.name')
            ->orderBy('districts.name', 'asc')
            ->having('total', '>', 0)
            ->get()
            ->map(function($district) {
                return (object) [
                    'name' => $district->name,
                    'total' => $district->total
                ];
            });
            
        $allDistricts = collect(array_unique([
            ...$data['by_district_not_yet']->pluck('name')->toArray(),
            ...$data['by_district_completed']->pluck('name')->toArray()
        ]))->sort()->values();
        
        $chartData = [];
        foreach ($allDistricts as $district) {
            $chartData[$district] = [
                'completed' => 0,
                'not_yet' => 0
            ];
        }
        
        foreach ($data['by_district_completed'] as $district) {
            $chartData[$district->name]['completed'] = $district->total;
        }
        
        foreach ($data['by_district_not_yet'] as $district) {
            $chartData[$district->name]['not_yet'] = $district->total;
        }
        
        $data['chart_data'] = [
            'categories' => array_keys($chartData),
            'series' => [
                [
                    'name' => 'Selesai',
                    'data' => array_column($chartData, 'completed')
                ],
                [
                    'name' => 'Masuk',
                    'data' => array_column($chartData, 'not_yet')
                ]
            ]
        ];

        $data['visit_schedule'] = Service::where('working_status', 'Process')
                                    ->whereNotNull('visit_schedule')
                                    ->get()
                                    ->map(function($service) {
                                        return [
                                            'title' => 'Kunjungan - ' . $service->user->full_name,
                                            'date' => $service->visit_schedule
                                        ];
                                    });                           

        // $data['services_by_category'] = DB::table('services')->select('service_category', DB::raw('COUNT(service_category) as total'))->groupBy('service_category')->get();
        return $data;
    }
        
    private function dashboardOperator() 
    {
        $districtId = auth()->user()->district_id;
    
        $counts = Service::query()
                    ->join('users', 'services.user_id', '=', 'users.id')
                    ->where('users.district_id', $districtId)
                    ->select([
                        DB::raw('COUNT(CASE 
                            WHEN service_status = "Not Yet" 
                            THEN 1 END) as incoming_visit'),
                            
                        DB::raw('COUNT(CASE 
                            WHEN service_status = "Process" 
                            AND working_status = "Process" 
                            AND document_recieved_status = "Not Yet Recieved"
                            THEN 1 END) as process_visit'),
                            
                        DB::raw('COUNT(CASE 
                            WHEN visit_schedule IS NOT NULL 
                            AND service_status = "Process"
                            AND working_status = "Process"
                            AND document_recieved_status = "Not Yet Recieved"
                            THEN 1 END) as visit_scheduled'),
                            
                        DB::raw('COUNT(CASE 
                            WHEN document_recieved_status = "Not Yet Recieved" 
                            AND working_status = "Done" 
                            AND service_status = "Process"
                            THEN 1 END) as document_recieved_visit'),
                            
                        DB::raw('COUNT(CASE 
                            WHEN service_status = "Completed" 
                            AND document_recieved_status = "Recieved"
                            THEN 1 END) as completed_visit')
                    ])
                    ->first();
    
        return [
            'incoming_visit' => $counts->incoming_visit,
            'process_visit' => $counts->process_visit,
            'visit_scheduled' => $counts->visit_scheduled,
            'document_recieved_visit' => $counts->document_recieved_visit,
            'completed_visit' => $counts->completed_visit
        ];
    }
}   

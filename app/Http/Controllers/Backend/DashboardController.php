<?php

namespace App\Http\Controllers\Backend;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->user()->role == 'admin') {
            $data = $this->dashboardAdmin();
            return $data;
            return view("Dashboard.dashboard_admin")->with([
                'data' => $data
            ]);
        } elseif (auth()->user()->role == 'operator') {
            $data = $this->dashboardOperator();
            return view("Dashboard.dashboard_operator")->with([
                'data' => $data
            ]);
        } elseif (auth()->user()->role == 'instance') {
            return view("Dashboard.dashboard_instance");
        } else {
            return view("Dashboard.dashboard_user");
        }
    }

    private function dashboardAdmin() {
        $baseQuery = Service::query();
        $data['incoming_visit'] = (clone $baseQuery)->where('service_status', 'Not Yet')->count();
        $data['process_visit'] = (clone $baseQuery)->where('service_status', 'Process')->count();
        $data['visit_scheduled'] = (clone $baseQuery)->whereNotNull('visit_schedule')->count();
        $data['document_recieved_visit'] = (clone $baseQuery)->where('document_recieved_status', 'Recieved')->count();
        $data['completed_visit'] = (clone $baseQuery)->where('service_status', 'Completed')->count();

        $data['services_by_district'] = DB::table('districts')
                                       ->leftJoin('users', 'districts.id', '=', 'users.district_id')
                                       ->leftJoin('services', 'users.id', '=', 'services.user_id')
                                       ->select('districts.name', DB::raw('COUNT(services.id) as total'))
                                       ->groupBy('districts.id', 'districts.name')
                                       ->get();

        $data['services_by_category'] = DB::table('services')->select('service_category', DB::raw('COUNT(service_category) as total'))->groupBy('service_category')->get();
        return $data;
    }
        
    private function dashboardOperator() 
    {
        $districtId = auth()->user()->district_id;
    
        $counts = Service::join('users', 'services.user_id', '=', 'users.id')
            ->where('users.district_id', $districtId)
            ->select([
                DB::raw('COUNT(CASE WHEN service_status = "Not Yet" THEN 1 END) as incoming_visit'),
                DB::raw('COUNT(CASE WHEN service_status = "Process" THEN 1 END) as process_visit'),
                DB::raw('COUNT(CASE WHEN visit_schedule IS NOT NULL THEN 1 END) as visit_scheduled'),
                DB::raw('COUNT(CASE WHEN document_recieved_status = "Recieved" THEN 1 END) as document_recieved_visit'),
                DB::raw('COUNT(CASE WHEN service_status = "Completed" THEN 1 END) as completed_visit')
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

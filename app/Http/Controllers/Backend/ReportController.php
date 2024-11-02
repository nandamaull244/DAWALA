<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\District;
use App\Models\Village;

class ReportController extends Controller
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

    $districts = District::orderBy('name', 'asc')->get();   
    $villages = Village::orderBy('name', 'asc')->get();

    return view('report.index', compact('services', 'districts', 'villages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function getData(Request $request)
    {
        $query = Service::query();

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->time) {
            $query->when($request->time == 'Terbaru', function($q) {
                return $q->orderBy('created_at', 'desc');
            })->when($request->time == 'Terlama', function($q) {
                return $q->orderBy('created_at', 'asc');
            });
        }

        // ... rest of your query logic ...
    }
}

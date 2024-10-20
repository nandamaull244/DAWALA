<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getVillagesByDistrict($districtId)
    {
        $villages = Village::where('district_id', $districtId)->get(['id', 'name']);
        return response()->json($villages);
    }
}

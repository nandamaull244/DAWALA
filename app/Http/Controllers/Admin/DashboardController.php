<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view("Dashboard.admin");
    }

    public function dashboardAdmin() {
        return view("Dashboard.admin.dashboardAdmin");
    }

    public function dashboardUser() {
        return view("Dashboard.user.dashboardUser");
    }


}   

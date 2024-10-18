<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        if (auth()->user()->role == 'admin') {
            return view("Dashboard.dashboard_admin");
        } elseif (auth()->user()->role == 'operator') {
            return view("Dashboard.dashboard_operator");
        } elseif (auth()->user()->role == 'instantiation') {
            return view("Dashboard.dashboard_instantiation");
        } else {
            return view("Dashboard.dashboard_user");
        }
    }
}   

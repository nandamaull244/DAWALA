<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function service()
    {
        return view('pages.layanan');
    }

    public function fastService()
    {
        return view('pages.layanan-cepat');
    }   

    public function documentation()
    {
        return view('pages.dokumentasi');
    }

    public function FAQ()
    {
        return view('pages.FAQ');
    }

    public function about()
    {
        return view('pages.tentang-dawala');
    }

    public function dawalaTeam()
    {
        return view('pages.tim-dawala');
    }

    public function visiMisi()
    {
        return view('pages.visi-misi');
    }
}

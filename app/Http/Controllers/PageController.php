<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Service;
use App\Models\ServiceForm;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function home()
    {
        $articles = Article::with('user')->orderBy('created_at', 'desc')->get();

        $service = Service::query();
        $data['total_visit'] = $service->count();
        $data['total_lansia'] = $service->where('service_category', 'LIKE', '%Lansia%')->count();
        $data['total_disabilitas'] = $service->where('service_category', 'LIKE', '%Disabilitas%')->count();
        $data['total_pengguna'] = User::where('role', '!=', 'Admin')->count();

        $serviceImage = ServiceImage::count();
        $serviceForm = ServiceForm::count();
        $data['total_dokumen_masuk'] = $serviceImage + $serviceForm;
       
        return view('pages.home', compact('articles', 'data'));
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
        $articles = Article::with('user')
                          ->orderBy('created_at', 'desc')
                          ->get();
        return view('pages.dokumentasi', compact('articles'));
    }

    public function documentationDetail(Article $article)
    {
        $article->load('user'); // Eager load user relationship
        return view('pages.dokumentasi_detail', compact('article'));
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
    
    public function detailPersyaratan()
    {
        return view('pages.detail-persyaratan');
    }
}

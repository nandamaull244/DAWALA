<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class PageController extends Controller
{
    public function home()
    {
        $articles = Article::with('user')
                          ->orderBy('created_at', 'desc')
                          ->get();
        return view('pages.home', compact('articles'));
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
}

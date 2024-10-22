<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('article.index');
    }

    public function getData(Request $request)
    {
        $query = Article::query();

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

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $hashedId = $row->getHashedId();
                $actionBtn = '<a href="'.route('admin.article.edit', $hashedId).'" style="cursor: pointer;">✏️</a> ';
                $actionBtn .= '<span data-bs-toggle="modal" data-bs-target="#deleteModalArticle" data-id="'.$hashedId.'" style="cursor: pointer;">🗑️</span>';
                return $actionBtn;
            })
            ->editColumn('title', function($row) {
                return '<p>' . $row->title . '</p> <p> Author : ' . $row->user->full_name . '</p>';
            })
            ->editColumn('image', function($row) {
                return $row->image_name 
                    ? '<img src="' . asset('storage/' . $row->image_name) . '" alt="' . $row->title . '" width="300" height="auto">' 
                    : 'No Image';
            })
            ->editColumn('body', function($row) {
                return Str::limit(strip_tags(htmlspecialchars_decode($row->body)), 30);
            })
            ->rawColumns(['title','action', 'image'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article();
        $article->user_id = auth()->user()->id;
        $article->slug = $request->slug;
        $article->title = htmlspecialchars($request->title);
        $article->body = htmlspecialchars($request->body);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();

            $path = storage_path('app/public/uploads/articles');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $fullPath = $path . '/' . $filename;

            $fileSize = $image->getSize();
            $maxSize = 6 * 1024 * 1024;

            if ($fileSize > $maxSize) {
                $img = Image::make($image->getRealPath());
                $img->resize(2400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $quality = 90;
                do {
                    $tempPath = $path . '/temp_' . $filename;
                    $img->save($tempPath, $quality);
                    
                    $compressedSize = File::size($tempPath);
                    
                    if ($compressedSize > $maxSize) {
                        $quality -= 3;
                    }
                    File::delete($tempPath);

                } while ($compressedSize > $maxSize && $quality > 0);

                $img->save($fullPath, $quality);
            } else {
                $image->move($path, $filename);
            }

            $article->image_name = 'uploads/articles/' . $filename;
            $article->original_name = $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
        }

        $article->save();

        return redirectByRole(auth()->user()->role, 'index', 'success', 'Data Artikel Berhasil Disimpan');
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
    public function edit($hashedId)
    {
        $article = Article::findByHash($hashedId);
        if (!$article) {
            abort(404);
        }
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hashedId)
    {
        $article = Article::findByHash($hashedId);
        if (!$article) {
            abort(404);
        }

        return redirect()->route('admin.article.index')->with(message('update', 'Artikel'));
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

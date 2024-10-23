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
                $actionBtn .= '<span class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModalArticle" data-id="'.$hashedId.'" style="cursor: pointer;">🗑️</span>';
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
        ]);

        try {
            $article = new Article();
            $article->user_id = auth()->user()->id;
            $article->slug = Str::slug($validatedData['title']);
            $article->title = htmlspecialchars($validatedData['title']);
            $article->body = htmlspecialchars($validatedData['body']);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = Str::random(12) . strtotime(date('dmY')) . '.' . $image->getClientOriginalExtension();

                if ($image->getSize() > 5 * 1024 * 1024) { 
                    $img = Image::make($image->getRealPath());
                    $img->resize(2400, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $path = storage_path('app/public/uploads/articles/' . $filename);
                    $img->save($path, 80);
                } else {
                    $image->storeAs('public/uploads/articles', $filename);
                }

                $article->image_name = 'uploads/articles/' . $filename;
                $article->original_name = $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
            }

            $article->save();

            return redirectByRole('admin', 'index', 'success', 'Artikel baru berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->route('admin.article.create')
                ->withInput()
                ->with('error', 'Gagal menyimpan artikel, ' . $e->getMessage());
        }
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
            return redirectByRole(auth()->user()->role, 'index', 'error', 'Data Artikel Tidak Ditemukan');
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
            return redirectByRole(auth()->user()->role, 'index', 'error', 'Data Artikel Tidak Ditemukan');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        try {
            $article->title = htmlspecialchars($validatedData['title']);
            $article->slug = Str::slug($validatedData['title']);
            $article->body = htmlspecialchars($validatedData['body']);

            if ($request->hasFile('image')) {
                if ($article->image_name) {
                    Storage::delete('public/uploads/articles/' . $article->image_name);
                }
                
                $image = $request->file('image');
                $filename = Str::random(12) . strtotime(date('dmY')) . '.' . $image->getClientOriginalExtension();

                if ($image->getSize() > 5 * 1024 * 1024) { 
                    $img = Image::make($image->getRealPath());
                    $img->resize(2400, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $path = storage_path('app/public/uploads/articles/' . $filename);
                    $img->save($path, 80);
                } else {
                    $image->storeAs('public/uploads/articles', $filename);
                }

                $article->image_name = 'uploads/articles/' . $filename;
                $article->original_name = $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
            }

            $article->update();

            return redirectByRole(auth()->user()->role, 'index', 'success', 'Artikel "' . $article->title . '" berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.article.edit', $hashedId)
                ->withInput()
                ->with('error', 'Gagal memperbarui artikel. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($hashedId)
    {
        $article = Article::findByHash($hashedId);
        if (!$article) {
            return redirectByRole(auth()->user()->role, 'index', 'error', 'Data Artikel Tidak Ditemukan');
        } else {
            $article->delete();
            return redirectByRole(auth()->user()->role, 'index', 'success', 'Artikel "' . $article->title . '" berhasil dihapus!');
        }
    }
}

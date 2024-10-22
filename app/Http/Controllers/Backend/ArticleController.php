<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
            $maxSize = 4 * 1024 * 1024;

            if ($fileSize > $maxSize) {
                $img = Image::make($image->getRealPath());
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $quality = 90;
                do {
                    $tempPath = $path . '/temp_' . $filename;
                    $img->save($tempPath, $quality);
                    
                    $compressedSize = File::size($tempPath);
                    
                    if ($compressedSize > $maxSize) {
                        $quality -= 5;
                    }
                    File::delete($tempPath);

                } while ($compressedSize > $maxSize && $quality > 0);

                $img->save($fullPath, $quality);
            } else {
                $image->move($path, $filename);
            }

            $article->image = 'uploads/articles/' . $filename;
        }

        $article->save();

        return redirect()->route('admin.article.index')->with('success', 'Artikel berhasil ditambahkan');
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
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Article, ArticleImage};
use Exception;
use Illuminate\Support\Facades\{Log, Storage};

class ArticleImageController extends Controller
{
    private $title;
    private $uploadPath;

    public function __construct()
    {
        $this->title = 'Detail Artikel';
        $this->uploadPath = 'uploads/articles/';
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data['title'] = $this->title;

        $article = Article::where('id', $id)->firstOrFail();

        $data['article'] = $article;
        $data['articleImage'] = ArticleImage::where('article_id', $article->id)->get();

        return view('dashboard.article.detail.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'article_id' => 'required|integer',
                'image' => 'required|mimes:jpeg,jpg,png|max:1024',
            ]);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store($this->uploadPath);
            }

            ArticleImage::create($data);

            $status = 'success';
            $message = 'Berhasil disimpan.';
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan. Ukuran file terlalu besar atau jenis file tidak valid.';
        }

        return redirect()->back()->with($status, $message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $article_id)
    {
        try {
            $data = $request->validate([
                'article_id' => 'required|integer',
                'image' => 'required|mimes:jpeg,jpg,png|max:1024',
            ]);

            $articleImage = ArticleImage::where(['article_id' => $article_id, 'id' => $request->id])->firstOrFail();

            if ($request->hasFile('image')) {
                if ($articleImage->image) {
                    Storage::delete($articleImage->image);
                }

                $data['image'] = $request->file('image')->store($this->uploadPath);
            }

            $articleImage->update($data);

            $status = 'success';
            $message = 'Berhasil disimpan.';
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            $status = 'danger';
            $message = 'Gagal disimpan. Ukuran file terlalu besar atau jenis file tidak valid.';
        }

        return redirect()->back()->with($status, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($article_id, $id)
    {
        try {
            $articleImage = ArticleImage::where(['article_id' => $article_id, 'id' => $id])->firstOrFail();
            Storage::delete($articleImage->image);

            $articleImage->delete();

            $status = 'success';
            $message = 'Berhasil dihapus';
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $status = 'danger';
            $message = 'Gagal dihapus.';
        }

        return redirect()->back()->with($status, $message);
    }
}

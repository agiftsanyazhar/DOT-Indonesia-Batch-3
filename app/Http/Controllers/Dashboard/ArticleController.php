<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Article};
use Exception;
use Illuminate\Support\Facades\{Auth, Log, Storage};

class ArticleController extends Controller
{
    private $title;
    private $uploadPath;

    public function __construct()
    {
        $this->title = 'Artikel';
        $this->uploadPath = 'uploads/articles/';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = $this->title;

        $data['articles'] = Article::all();

        return view('dashboard.article.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
                'featured_image' => 'nullable|mimes:jpeg,jpg,png|max:1024',
            ]);

            $data['user_id'] = Auth::id();

            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = $request->file('featured_image')->store($this->uploadPath);
            }

            Article::create($data);

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
    public function update(Request $request)
    {
        try {
            $article = Article::findOrFail($request->id);

            $data = $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
                'featured_image' => 'nullable|mimes:jpeg,jpg,png|max:1024',
            ]);

            $data['user_id'] = Auth::id();

            if ($request->hasFile('featured_image')) {
                if ($article->featured_image) {
                    Storage::delete($article->featured_image);
                }

                $data['featured_image'] = $request->file('featured_image')->store($this->uploadPath);
            }

            $article->update($data);

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
    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);

            if ($article->featured_image) {
                Storage::delete($article->featured_image);
            }

            $article->delete();

            $status = 'success';
            $message = 'Berhasil dihapus.';
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            $status = 'danger';
            $message = 'Gagal dihapus.';
        }

        return redirect()->back()->with($status, $message);
    }
}

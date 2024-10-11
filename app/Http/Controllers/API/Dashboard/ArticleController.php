<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\{ArticleRequest};
use Illuminate\Http\Request;

use App\Models\{Article};
use Exception;
use Illuminate\Support\Facades\{Log, Storage};
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    private $uploadPath;

    public function __construct()
    {
        $this->uploadPath = 'uploads/articles/';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['user', 'articleImage'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data articles success',
            'data' => $articles
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        try {
            $data = $request->only([
                'title',
                'description',
                'featured_image',
                'user_id',
            ]);

            $data['user_id'] = $request->user()->id;

            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = $request->file('featured_image')->store($this->uploadPath);
            }

            $article = Article::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Article Successfully Added.',
                'data' => $article,
            ], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => $errors,
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['user', 'articleImage']);

        return response()->json([
            'success' => true,
            'message' => 'Article Detail.',
            'data' => $article,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        try {
            $data = $request->only([
                'title',
                'description',
                'featured_image',
                'user_id',
            ]);

            $data['user_id'] = $request->user()->id;

            if ($request->hasFile('featured_image')) {
                if ($article->featured_image) {
                    Storage::delete($article->featured_image);
                }

                $data['featured_image'] = $request->file('featured_image')->store($this->uploadPath);
            }

            $article->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Article Successfully Updated.',
                'data' => $article,
            ], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => $errors,
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            if ($article->featured_image) {
                Storage::delete($article->featured_image);
            }

            $article->delete();

            return response()->json([
                'success' => true,
                'message' => 'Article Successfully Deleted.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

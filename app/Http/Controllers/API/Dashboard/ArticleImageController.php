<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleImageRequest;
use Illuminate\Http\Request;

use App\Models\{ArticleImage};
use Exception;
use Illuminate\Support\Facades\{Log, Storage};
use Illuminate\Validation\ValidationException;

class ArticleImageController extends Controller
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
        $articleImage = ArticleImage::with(['article'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data images success',
            'data' => $articleImage
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleImageRequest $request)
    {
        try {
            $data = $request->only([
                'article_id',
                'image',
            ]);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store($this->uploadPath);
            }

            $articleImage = ArticleImage::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Image successfully added.',
                'data' => $articleImage,
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
    public function show($id)
    {
        $articleImage = ArticleImage::where('article_id', $id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Get data article detail success',
            'data' => $articleImage
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleImageRequest $request, ArticleImage $articleImage)
    {
        try {
            $data = $request->only([
                'article_id',
                'image',
            ]);

            if ($request->hasFile('image')) {
                if ($articleImage->image) {
                    Storage::delete($articleImage->image);
                }

                $data['image'] = $request->file('image')->store($this->uploadPath);
            }

            $articleImage->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Image successfully updated.',
                'data' => $articleImage,
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
    public function destroy($id)
    {
        try {
            $articleImage = ArticleImage::findOrFail($id);

            if ($articleImage->image) {
                Storage::delete($articleImage->image);
            }

            $articleImage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image successfully deleted.',
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

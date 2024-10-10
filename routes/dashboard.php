<?php

use App\Http\Controllers\Dashboard\{
    ArticleController,
};

use Illuminate\Support\Facades\Route;

Route::prefix('artikel')->name('article.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::post('/store', [ArticleController::class, 'store'])->name('store');
    Route::post('/update', [ArticleController::class, 'update'])->name('update');
    Route::get('/destroy/{id}', [ArticleController::class, 'destroy'])->name('destroy');
    Route::get('/update/status/{id}', [ArticleController::class, 'updateStatus'])->name('update.status');
    // Route::prefix('detail')->name('detail.')->group(function () {
    //     Route::get('/{article_id}', [ArticleImageController::class, 'index'])->name('index');
    //     Route::post('/{article_id}/store', [ArticleImageController::class, 'store'])->name('store');
    //     Route::post('/{article_id}/update', [ArticleImageController::class, 'update'])->name('update');
    //     Route::get('/{article_id}/destroy/{id}', [ArticleImageController::class, 'destroy'])->name('destroy');
    // });
});

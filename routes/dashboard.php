<?php

use App\Http\Controllers\Dashboard\{
    ArticleController,
};

use Illuminate\Support\Facades\Route;

Route::prefix('article')->name('article.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    // Route::post('/store', [ReimbursmentController::class, 'store'])->name('store');
    // Route::post('/update', [ReimbursmentController::class, 'update'])->name('update');
    // Route::get('/update/status/{id}/approve', [ReimbursmentController::class, 'approve'])->name('update-status.approve');
    // Route::get('/update/status/{id}/reject', [ReimbursmentController::class, 'reject'])->name('update-status.reject');
    // Route::get('/destroy/{id}', [ReimbursmentController::class, 'destroy'])->name('destroy');
});

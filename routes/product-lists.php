<?php

use App\Http\Controllers\CompareApiController;
use App\Http\Controllers\FavoritesApiController;
use App\Http\Controllers\ProductListPageController;
use Illuminate\Support\Facades\Route;

Route::get('/favorites', [ProductListPageController::class, 'favorites'])->name('favorites.index');
Route::get('/compare', [ProductListPageController::class, 'compare'])->name('compare.index');

Route::prefix('favorites/api')->name('favorites.api.')->group(function () {
    Route::get('/', [FavoritesApiController::class, 'index'])->name('index');
    Route::post('/toggle', [FavoritesApiController::class, 'toggle'])->name('toggle');
    Route::delete('/delete', [FavoritesApiController::class, 'delete'])->name('delete');
    Route::delete('/clear', [FavoritesApiController::class, 'clear'])->name('clear');
});

Route::prefix('compare/api')->name('compare.api.')->group(function () {
    Route::get('/', [CompareApiController::class, 'index'])->name('index');
    Route::post('/toggle', [CompareApiController::class, 'toggle'])->name('toggle');
    Route::delete('/delete', [CompareApiController::class, 'delete'])->name('delete');
    Route::delete('/clear', [CompareApiController::class, 'clear'])->name('clear');
});

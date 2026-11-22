<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('pages')->group(function () {
    Route::get('/{page}', [PageController::class, 'show'])->name('page.show');
});

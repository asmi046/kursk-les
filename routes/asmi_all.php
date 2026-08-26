<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');

<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RestaurantOfferController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::get('/restaurant-offer', [RestaurantOfferController::class, 'index'])->name('restaurant-offer');

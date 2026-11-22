<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestaurantOfferController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::get('/restaurant-offer', [RestaurantOfferController::class, 'index'])->name('restaurant-offer');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/category/{slug}', [CatalogController::class, 'category'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

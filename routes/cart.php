<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartPageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Route;

Route::get('/cart', [CartPageController::class, 'index'])->name('cart');
Route::get('/cart/thanks', [CartPageController::class, 'thanks'])->name('cart.thanks');

Route::prefix('cart/api')->name('cart.api.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::delete('/delete', [CartController::class, 'delete'])->name('delete');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');
});

Route::prefix('delivery')->name('delivery.')->group(function () {
    Route::get('/cities', [DeliveryController::class, 'cities'])->name('cities');
    Route::post('/pickup-points', [DeliveryController::class, 'pickupPoints'])->name('pickup-points');
    Route::post('/tariffs', [DeliveryController::class, 'tariffs'])->name('tariffs');
});

/*
|--------------------------------------------------------------------------
| ОПЛАТА (YooKassa) — закомментировано до подключения боевых доступов.
|
| Route::post('/pay_hook', [PayController::class, 'hook'])->name('pay.hook');
|--------------------------------------------------------------------------
*/

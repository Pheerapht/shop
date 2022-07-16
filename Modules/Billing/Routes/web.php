<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\PaypalController;
use Modules\Billing\Http\Controllers\StripeController;
use Modules\Billing\Http\Controllers\WishlistController;
use Modules\Front\Service\FrontController;
use Modules\Order\Http\Controllers\OrderFrontController;

Route::get('/wishlist', function () {
    return view('frontend.pages.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}', [WishlistController::class, 'wishlist'])->name('add-to-wishlist');
Route::get('wishlist-delete/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist-delete');
Route::post('cart/order', [OrderFrontController::class, 'store'])->name('cart.order');
Route::get('order/pdf/{id}', [OrderFrontController::class, 'pdf'])->name('order.pdf');
Route::get('/income', [OrderFrontController::class, 'incomeChart'])->name('product.order.income');
Route::get('/product-grids', [FrontController::class, 'productGrids'])->name('product-grids');
Route::get('/product-lists', [FrontController::class, 'productLists'])->name('product-lists');
Route::match(['get', 'post'], '/filter', [FrontController::class, 'productFilter'])->name('shop.filter');
// Payment
Route::get('payment', [PayPalController::class, 'payment'])->name('payment');
Route::get('cancel', [PayPalController::class, 'cancel'])->name('payment.cancel');
Route::get('payment/success', [PayPalController::class, 'success'])->name('payment.success');
//Stripe
Route::get('stripe/{id}', [StripeController::class, 'stripe'])->name('stripe');
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ContohResourceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/2', [HomeController::class, 'index2']);

Route::resource('contoh', ContohResourceController::class);

// Route::get('/products/{id}', [HomeController::class, 'productDetail'])->name('product-detail');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product-detail');

Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('cart/update/{productId}', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/checkout', [TransactionController::class, 'checkoutPage'])->name('checkout');

Route::post('/checkout/process', [TransactionController::class, 'store'])->name('checkout.process');

Route::get('/checkout/success/{transaction_id}', [TransactionController::class, 'show'])->name('checkout.success');

Route::get('/transaction-status', function () {
    return view('transaction-status');
})->name('transaction-status');

Route::get('/contact', function () {
    return "This is the Contact Page";
    // return view('welcome');
})->name('contact');


Route::prefix('dashboard')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::resource('products', ProductController::class);
    Route::resource('product-categories', ProductCategoryController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('products/{product_id}/categories/{category_id}', [HomeController::class, 'productCategory'])->name('product-category'); // route('product-category', ['product_id' => 1, 'category_id' => 2])

require __DIR__.'/auth.php';

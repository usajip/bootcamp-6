<?php

use App\Http\Controllers\ContohResourceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Route::get('/', function () {
//     return "Welcome to E-commerce Application";
//     // return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/2', [HomeController::class, 'index2']);

Route::resource('contoh', ContohResourceController::class);

Route::get('/products/{id}', [HomeController::class, 'productDetail'])->name('product-detail');

Route::get('cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/transaction-status', function () {
    return view('transaction-status');
})->name('transaction-status');

Route::get('/contact', function () {
    return "This is the Contact Page";
    // return view('welcome');
})->name('contact');


// Route::middleware('throttle:5,1')->group(function () {
//     Route::get('products', function () {
//         return "This is the Products Page";
//     });
// });
// Route::get('products-page/{id}', function ($id) {
//     return "This is the Products Page for product with ID: " . $id;
// });
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

Route::get('/products/{id}', [HomeController::class, 'productDetail']);

Route::get('/cart', function () {
    return "This is the Cart Page";
    // return view('welcome');
});

Route::get('/checkout', function () {
    return "This is the Checkout Page";
    // return view('welcome');
});

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

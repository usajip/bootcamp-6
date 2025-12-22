<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Welcome to E-commerce Application";
    // return view('welcome');
});

Route::get('/products', function () {
    // return "This is the Products Page";
    return view('product');
});

Route::get('/cart', function () {
    return "This is the Cart Page";
    // return view('welcome');
});

Route::get('/checkout', function () {
    return "This is the Checkout Page";
    // return view('welcome');
});


// Route::middleware('throttle:5,1')->group(function () {
//     Route::get('products', function () {
//         return "This is the Products Page";
//     });
// });
// Route::get('products-page/{id}', function ($id) {
//     return "This is the Products Page for product with ID: " . $id;
// });

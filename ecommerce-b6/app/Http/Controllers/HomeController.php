<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $name = "<b>John Doe</b>";

        $products = [
            'Product 1',
            'Product 2',
            'Product 3',
            'Product 4',
        ];

        return view('home');
    }

    public function productDetail($id)
    {
        return "Product Detail for Product ID: " . $id;
    }
}

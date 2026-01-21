<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('product_category')
                        ->where('stock', '>', 20)
                        ->orderBy('created_at', 'desc')
                        ->paginate(6);

        return view('home', compact('products'));
    }
}

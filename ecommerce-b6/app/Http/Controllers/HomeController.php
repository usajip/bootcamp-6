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

    public function productDetail($id)
    {
        $product = Product::with('product_category')
                        ->findOrFail($id); // nampilin detail produk berdasarkan id

        $recommendedProducts = Product::where('product_category_id', $product->product_category_id)
                                    ->where('id', '!=', $product->id)
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get();// nampilin banyak produk rekomendasi
        // dd($product, $recommendedProducts);

        return view('product-detail', compact('product', 'recommendedProducts'));
    }
}

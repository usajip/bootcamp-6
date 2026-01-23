<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $products = Product::with('product_category')
                        ->where('stock', '>', 20)
                        ->orderBy('created_at', 'desc');
        if ($search) {
            $products->where('name', 'like', '%'.$search.'%');
        }
        if ($category) {
            $products->where('product_category_id', $category);
        }
        $products = $products->paginate(6);

        $categories = ProductCategory::all();

        return view('home', compact('products', 'categories'));
    }
}

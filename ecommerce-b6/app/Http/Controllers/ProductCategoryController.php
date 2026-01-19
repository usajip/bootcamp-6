<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::withCount('products')
                                ->withSum('products as total_stock' , 'stock')
                                ->withSum('products as total_price' , 'price')
                                ->get();

        return view('admin.product-category.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:100|unique:product_categories,name',
            'description' => 'nullable|string',
        ]);

        ProductCategory::create($validatedData);

        return back()->with('success', 'Kategori produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:100|unique:product_categories,name,' . $productCategory->id,
            'description' => 'nullable|string',
        ]);

        // ProductCategory::where('name', $request->name)->whereNot('id', '!=', $productCategory->id)->exists();

        $productCategory->update($validatedData);

        // $productCategory->name = $request->name;
        // $productCategory->description = $request->description;
        // $productCategory->save();

        return back()->with('success', 'Kategori produk dengan id: '.$productCategory->id.' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->exists()) {
            return back()->withErrors(['Kategori produk: <b>' . $productCategory->name . '</b> tidak dapat dihapus karena masih memiliki produk.']);
        }

        $productCategory->delete();

        return back()->with('success', 'Kategori produk dengan id: '.$productCategory->id.' berhasil dihapus.');
    }
}

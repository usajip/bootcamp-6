<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with([
                        'product_category',
                        'transaction_items' => function ($query) {
                            $query->whereDate('created_at', now());
                        }
                    ])
                    ->withCount('transaction_items')
                    ->orderBy('id', 'desc')
                    ->paginate(5);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|min:5|max:100|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            // 'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:1024', // max 1MB
            'image' => 'required|string', // base64 image string
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->product_category_id = $request->product_category_id;
        // upload image from base64 string
        if ($request->image) {
            $imageData = $request->image;
            list($type, $imageData) = explode(';', $imageData);
            list(, $imageData) = explode(',', $imageData);
            $imageData = base64_decode($imageData);
            $imageName = 'products/' . uniqid() . '.webp';
            Storage::disk('assets')->put($imageName, $imageData);
            $product->image_url = $imageName;
        }
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('products', 'assets');
        //     $product->	image_url = $imagePath;
        // }else{
        //     return back()->with('errors', ['Gagal mengunggah gambar produk.']);
        // }
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('product_category')
                        ->findOrFail($id); // nampilin detail produk berdasarkan id

        $recommendedProducts = Product::where('product_category_id', $product->product_category_id)
                                    ->where('id', '!=', $product->id)
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get();// nampilin banyak produk rekomendasi
        // add click count to the product data on the database using session to avoid multiple click count from the same user in a short time
        $session = session();
        $clickKey = 'product_click_' . $product->id;
        if (!$session->has($clickKey)) {
            $session->put($clickKey, true);
            // add click counter to database
            $product->click += 1;
            $product->save();
        }

        return view('product-detail', compact('product', 'recommendedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        return view('admin.product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:100|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|string', // base64 image string
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->product_category_id = $request->product_category_id;
        // upload image from base64 string
        if ($request->image) {
            if(Storage::disk('assets')->exists($product->image_url)){
                Storage::disk('assets')->delete($product->image_url);
            }
            $imageData = $request->image;
            list($type, $imageData) = explode(';', $imageData);
            list(, $imageData) = explode(',', $imageData);
            $imageData = base64_decode($imageData);
            $imageName = 'products/' . uniqid() . '.webp';
            Storage::disk('assets')->put($imageName, $imageData);
            $product->image_url = $imageName;
        }
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->transaction_items()->exists()) {
            return back()->withErrors(['Produk: <b>' . $product->name . '</b> tidak dapat dihapus karena masih memiliki transaksi.']);
        }

        if(Storage::disk('assets')->exists($product->image_url)){
            Storage::disk('assets')->delete($product->image_url);
        }

        $product->delete();

        return back()->with('success', 'Produk dengan id: '.$product->id.' berhasil dihapus.');
    }
}

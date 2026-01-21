<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $session = session()->get('cart', []);

        $cart_items = [];
        foreach ($session as $productId => $item) {
            $product = Product::find($productId);
            if (!$product) {
                continue;
            }
            $cart_items[] = [
                'id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'image_url' => asset('assets/'.$product->image_url),
                'quantity' => $item['quantity'],
            ];
        }

        return view('cart', compact('cart_items'));
    }

    public function addToCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        $quantity = $request->input('quantity', 1);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        $quantity = $request->input('quantity', 1);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function removeFromCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}

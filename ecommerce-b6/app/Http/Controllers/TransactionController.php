<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function checkoutPage()
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

        return view('checkout', compact('cart_items'));
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
        $cart_session = session()->get('cart', []);

        if(Auth::check() && !empty($cart_session)) {
            $request->validate([
                'address' => 'required|string|min:10|max:255',
                'phone' => 'required|string|min:10|max:20',
            ]);

            $user = User::find(Auth::id());
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->name = $user->name;
            $transaction->address = $request->address;
            $transaction->phone = $request->phone;
            $transaction->status = 'pending';
            $transaction->total_amount = 0;
            $transaction->save();

            foreach ($cart_session as $productId => $item) {
                $product = Product::find($productId);
                if (!$product) {
                    continue;
                }
                $transaction->transaction_items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
                // reduce stock
                $product->stock -= $item['quantity'];
                $product->save();

                $transaction->total_amount += $product->price * $item['quantity'];
            }
            $transaction->save();

            // clear cart session
            session()->forget('cart');
            return redirect()->route('checkout.success', ['transaction_id'=>$transaction->id])->with('success', 'Checkout successful!');
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to checkout.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = Transaction::with('transaction_items.product')->findOrFail($id);
        return view('transaction-status', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}

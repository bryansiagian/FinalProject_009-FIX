<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['quantity' => $request->quantity]
        );

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}

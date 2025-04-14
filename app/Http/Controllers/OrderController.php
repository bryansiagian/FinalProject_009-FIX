<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('warning', 'Keranjang belanja Anda kosong!');
        }

        $shippingMethods = [
            'delivery' => [
                'name' => 'Delivery',
                'cost' => 10000,
            ],
            'self_pickup' => [
                'name' => 'Self Pick-up',
                'cost' => 0,
            ],
        ];

        return view('orders.create', compact('cartItems', 'shippingMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|string|in:delivery,self_pickup',
            'shipping_address' => 'required_if:shipping_method,delivery|nullable|string',
            'product_id' => 'sometimes|required|exists:products,id', // Validasi jika product_id ada
            'quantity' => 'sometimes|required|integer|min:1', // Validasi jika quantity ada
            'from_product_page' => 'sometimes|accepted', // Validasi untuk menandai pesanan langsung
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $shippingCost = 0;
            $orderItems = [];

            // Ambil biaya pengiriman
            if ($request->shipping_method == 'delivery') {
                $shippingCost = config('app.delivery_cost', 15000);
            }
            $totalAmount += $shippingCost;

            // Tentukan apakah pesanan berasal dari cart atau langsung dari produk
            if ($request->has('from_product_page')) {
                // Pesanan langsung dari produk
                $product = Product::find($request->product_id);

                if (!$product) {
                    DB::rollback();
                    return back()->with('error', 'Produk tidak ditemukan.');
                }

                if ($product->stock < $request->quantity) {
                    DB::rollback();
                    return back()->with('error', 'Stok tidak mencukupi untuk produk ' . $product->name . '.');
                }

                $totalAmount += $product->price * $request->quantity;
                $orderItems[] = [
                    'product' => $product,
                    'quantity' => $request->quantity,
                ];
            } else {
                // Pesanan dari cart
                $cartItems = Cart::where('user_id', Auth::id())->get();

                if ($cartItems->isEmpty()) {
                    DB::rollback();
                    return redirect()->route('products.index')->with('warning', 'Keranjang belanja Anda kosong!');
                }

                foreach ($cartItems as $item) {
                    $product = Product::find($item->product_id);

                    if (!$product) {
                        DB::rollback();
                        Log::error('Produk tidak ditemukan: product_id=' . $item->product_id);
                        return back()->with('error', 'Produk tidak ditemukan. Silakan coba lagi.');
                    }

                    if ($product->stock < $item->quantity) {
                        DB::rollback();
                        Log::warning('Stok tidak mencukupi: product_id=' . $product->product_id . ', stok=' . $product->stock . ', quantity=' . $item->quantity);
                        return back()->with('error', 'Stok tidak mencukupi untuk produk ' . $product->name . '.');
                    }

                    $totalAmount += $product->price * $item->quantity;
                    $orderItems[] = [
                        'product' => $product,
                        'quantity' => $item->quantity,
                    ];
                }
                // Hapus item dari keranjang setelah pesanan berhasil dibuat dari cart
                Cart::where('user_id', Auth::id())->delete();
            }

            // Buat Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'payment_method' => 'cash',
                'shipping_method' => $request->shipping_method, // Ambil dari form
                'shipping_address' => $request->shipping_address, // Ambil dari form
            ]);

            // Buat Order Items dan kurangi stok
            foreach ($orderItems as $orderItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $orderItem['product']->id,
                    'quantity' => $orderItem['quantity'],
                    'price' => $orderItem['product']->price,
                ]);

                $product = $orderItem['product']; // Pastikan Anda menggunakan produk yang benar
                $product->decrement('stock', $orderItem['quantity']);
            }

            DB::commit();
            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal membuat pesanan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.show', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
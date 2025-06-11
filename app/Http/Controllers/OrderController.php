<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\WilayahDesa;
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

        $user = Auth::user();
        $wilayahDesa = $user->wilayahDesa;

        $shippingMethods = [];
        if ($wilayahDesa) {
            $shippingMethods = [
                'delivery' => [
                    'name' => 'Delivery',
                    'cost' => $wilayahDesa->ongkos_kirim,
                    'tersedia' => $wilayahDesa->tersedia_delivery,
                ],
                'self_pickup' => [
                    'name' => 'Self Pick-up',
                    'cost' => 0,
                    'tersedia' => true,
                ],
            ];
        } else {
            // Handle kasus jika user tidak memiliki wilayah desa (misalnya, set self pickup saja)
            $shippingMethods = [
                'self_pickup' => [
                    'name' => 'Self Pick-up',
                    'cost' => 0,
                    'tersedia' => true,
                ],
            ];
        }

        // Hitung total harga barang
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $subtotal += $product->price * $item->quantity;
            }
        }

        return view('orders.create', compact('cartItems', 'shippingMethods', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|string|in:delivery,self_pickup',
            'shipping_address' => 'required_if:shipping_method,delivery|nullable|string',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'from_product_page' => 'sometimes|accepted',
        ]);

        $user = Auth::user();
        $wilayahDesa = $user->wilayahDesa;

        if ($request->shipping_method == 'delivery' && (!$wilayahDesa || !$wilayahDesa->tersedia_delivery)) {
            return back()->withErrors(['shipping_method' => 'Maaf, delivery tidak tersedia untuk wilayah Anda. Silakan pilih Self Pick-up.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $shippingCost = 0;
            $orderItems = [];

            // Ambil biaya pengiriman
            if ($request->shipping_method == 'delivery') {
                $shippingCost = $wilayahDesa->ongkos_kirim;
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
                'shipping_method' => $request->shipping_method,
                'shipping_address' => $request->shipping_address,
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

        $order->load('orderItems.product');

        $user = Auth::user();
        $wilayahDesa = $user->wilayahDesa;

        $shippingCost = 0;
        if ($order->shipping_method == 'delivery' && $wilayahDesa) {
            $shippingCost = $wilayahDesa->ongkos_kirim;
        }

        return view('orders.show', compact('order', 'shippingCost'));
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

    public function cancel(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.index')->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        DB::beginTransaction();
        try {
            // Batalkan pesanan
            $order->status = 'cancelled';

            // Kembalikan stok produk
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $order->save();

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal membatalkan pesanan: ' . $e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Terjadi kesalahan saat membatalkan pesanan.');
        }
    }
}
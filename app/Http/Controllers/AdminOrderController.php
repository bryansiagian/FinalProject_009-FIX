<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with('user')->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $orders->where('status', $request->status);
        }

        // Filter berdasarkan tanggal pembuatan pesanan (created_at)
        if ($request->has('tanggal_pesanan') && $request->tanggal_pesanan != '') {
            $orders->whereDate('created_at', $request->tanggal_pesanan);
        }

        // Filter berdasarkan pelanggan
        if ($request->has('pelanggan') && $request->pelanggan != '') {
            $orders->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->pelanggan . '%');
            });
        }

        $orders = $orders->paginate(10);

        // Hitung total harga pesanan hanya untuk status 'completed'
        $totalHargaSeluruhPesanan = Order::where('status', 'completed')->sum('total_amount');

        return view('admin.orders.index', compact('orders', 'totalHargaSeluruhPesanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create'); // Membuat form untuk membuat pesanan baru (jarang digunakan)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dan simpan data pesanan baru (jarang digunakan)
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order = Order::with('user', 'orderItems.product')->findOrFail($order->id); // Eager load relasi dan ambil data

        return view('admin.orders.show', compact('order')); // Menampilkan detail pesanan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order')); // Form untuk mengedit pesanan
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled', // Contoh validasi
            // tambahkan validasi untuk field lain yang bisa di edit
        ]);

        $order->update($request->all());

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}

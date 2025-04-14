<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10); // Eager load relasi user
        return view('admin.orders.index', compact('orders'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 'pending')->get(); // Ambil pesanan dengan status "pending"
        return view('admin.dashboard', compact('orders'));
    }

    public function verifyOrder(Order $order)
    {
        $order->status = 'processing'; // Ubah status menjadi "processing" atau status lain yang sesuai
        $order->save();

        return back()->with('success', 'Pesanan berhasil diverifikasi!');
    }

    public function completeOrder(Order $order)
    {
        $order->status = 'completed'; // Ubah status menjadi "completed"
        $order->save();

        return back()->with('success', 'Pesanan berhasil diselesaikan!');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::with('user')->latest()->get(); // Ambil semua testimoni, urutkan berdasarkan terbaru
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Order; // Import model Order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->whereNull('product_id') // Tambahkan kondisi ini (ini untuk testimoni umum, bukan testimoni produk)
            ->latest()
            ->paginate(10); // Ambil 10 testimoni per halaman, yang sudah disetujui

        return view('testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('testimonial.create'); // Asumsi view ada di direktori profile/testimonial
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
            'product_id' => 'required|exists:products,id', // Validasi product_id
        ]);

        // Ambil user yang login
        $user = Auth::user();

        // Validasi apakah user sudah membeli produk ini
        $hasPurchased = Order::where('user_id', $user->id)
            ->whereHas('orderItems', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->where('status', 'completed') // Atau sesuaikan dengan status order Anda
            ->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['message' => 'Anda belum membeli produk ini. Anda tidak bisa memberikan testimoni.'])->withInput();
        }

        // Validasi apakah user sudah memberikan testimoni untuk produk ini
        $hasExistingTestimonial = Testimonial::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($hasExistingTestimonial) {
            return back()->withErrors(['message' => 'Anda sudah memberikan testimoni untuk produk ini.'])->withInput();
        }

        Testimonial::create([
            'user_id' => $user->id, // Gunakan $user->id
            'content' => $request->content,
            'rating' => $request->rating,
            'product_id' => $request->product_id, // Simpan product_id
        ]);

        // Redirect kembali ke halaman detail produk
        return redirect()->route('products.index', $request->product_id)->with('success', 'Testimoni Anda berhasil dikirim!'); // Ubah ke route yang benar
    }

    public function editTestimonial(Testimonial $testimonial)
    {
        // Pastikan user yang login adalah pemilik testimoni
        if ($testimonial->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit testimoni ini.'); // Atau redirect ke halaman lain
        }

        return view('testimonial.edit', compact('testimonial'));
    }

    // Menyimpan perubahan testimoni
    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        // Pastikan user yang login adalah pemilik testimoni
        if ($testimonial->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit testimoni ini.'); // Atau redirect ke halaman lain
        }

        $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $testimonial->update([
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        return redirect()->route('products.index')->with('success', 'Testimoni Anda berhasil diperbarui!');
    }

    // Menghapus testimoni
    public function destroyTestimonial(Testimonial $testimonial)
    {
        // Pastikan user yang login adalah pemilik testimoni
        if ($testimonial->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus testimoni ini.'); // Atau redirect
        }

        $testimonial->delete();

        return redirect()->route('products.index')->with('success', 'Testimoni Anda berhasil dihapus!');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::with('user')->latest()->get(); // Ambil semua testimoni, urutkan berdasarkan terbaru
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function destroyTestimonialAdmin(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
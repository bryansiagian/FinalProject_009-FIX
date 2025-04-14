<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('user')
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
            'content' => 'required|string|max:500', // Contoh validasi
            'rating' => 'nullable|integer|min:1|max:5', // Contoh validasi rating
        ]);

        Testimonial::create([
            'user_id' => Auth::id(), // Menggunakan user yang sedang login
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        return redirect()->route('testimonial.index')->with('success', 'Testimoni Anda berhasil dikirim!'); // Redirect ke halaman profil
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

        return redirect()->route('profile.index')->with('success', 'Testimoni Anda berhasil diperbarui!');
    }

    // Menghapus testimoni
    public function destroyTestimonial(Testimonial $testimonial)
    {
        // Pastikan user yang login adalah pemilik testimoni
        if ($testimonial->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus testimoni ini.'); // Atau redirect
        }

        $testimonial->delete();

        return redirect()->route('profile.index')->with('success', 'Testimoni Anda berhasil dihapus!');
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

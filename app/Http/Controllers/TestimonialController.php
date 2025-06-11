<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\NewTestimonial; // Import Mailable
use Illuminate\Support\Facades\Mail; // Import Mail Facade

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->whereNull('product_id')
            ->where('status', 'approved') // Hanya tampilkan testimoni yang disetujui
            ->latest()
            ->paginate(10);

        return view('testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('testimonial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();

        $hasPurchased = Order::where('user_id', $user->id)
            ->whereHas('orderItems', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->where('status', 'completed')
            ->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['message' => 'Anda belum membeli produk ini.'])->withInput();
        }

        $hasExistingTestimonial = Testimonial::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($hasExistingTestimonial) {
            return back()->withErrors(['message' => 'Anda sudah memberikan testimoni untuk produk ini.'])->withInput();
        }

        $testimonialData = [
            'user_id' => $user->id,
            'content' => $request->content,
            'rating' => $request->rating,
            'product_id' => $request->product_id,
            'status' => 'pending', // Testimoni baru selalu berstatus 'pending'
        ];

        $testimonial = Testimonial::create($testimonialData);

        // Kirim email notifikasi ke admin
        try {
            Mail::to('admin@example.com')->send(new NewTestimonial($testimonial));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email notifikasi testimoni: ' . $e->getMessage());
            // Anda mungkin ingin menambahkan logika di sini untuk memberi tahu admin tentang kegagalan pengiriman email
        }

        return redirect()->route('products.show', $request->product_id)->with('success', 'Testimoni Anda berhasil dikirim dan menunggu persetujuan admin!');
    }

    public function editTestimonial(Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit testimoni ini.');
        }

        return view('testimonial.edit', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit testimoni ini.');
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

    public function destroyTestimonial(Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus testimoni ini.');
        }

        $testimonial->delete();

        return redirect()->route('products.index')->with('success', 'Testimoni Anda berhasil dihapus!');
    }

    public function testimonials(Request $request)
    {
        $testimonials = Testimonial::with('user')->latest();

        // Filter berdasarkan rating
        if ($request->has('rating') && $request->rating != '') {
            $testimonials->where('rating', $request->rating);
        }

        $testimonials = $testimonials->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function approveTestimonial(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'approved']);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil disetujui!');
    }

    public function rejectTestimonial(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'rejected']);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditolak!');
    }

    public function destroyTestimonialAdmin(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // **Public Methods (Guest/Pelanggan)**

    /**
     * Display a listing of the products (for guest/customers).
     */
    public function showFront(Request $request) // 1. Tambahkan Request $request
    {
        // 2. Ambil keyword pencarian dari request
        $searchTerm = $request->input('search');

        // 3. Mulai query builder
        $query = Product::query();

        // 4. Jika ada keyword pencarian, tambahkan kondisi WHERE
        if ($searchTerm) {
            // Cari produk yang namanya mengandung $searchTerm (case-insensitive tergantung konfigurasi DB)
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
            // Jika ingin mencari di deskripsi juga, uncomment baris di bawah dan sesuaikan:
            // $query->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        }

        // 5. Ambil produk (misalnya diurutkan berdasarkan nama atau tanggal dibuat)
        // Ganti Product::all() dengan hasil query builder
        $products = $query->orderBy('created_at', 'desc')->get(); // Contoh: urutkan berdasarkan terbaru
        foreach ($products as $product) {
            $product->load('testimonials.user');
        }

        // 6. Kirim data produk yang sudah difilter ke view
        // Pastikan view 'products.index' adalah view yang menampilkan daftar produk untuk pelanggan
        return view('products.index', compact('products'));
    }

    /**
     * Display the specified product (for guest/customers).
     */
    public function show(Product $product)
    {
        $product->load('testimonials.user'); // Eager load testimonials dan user yang membuat
        return view('products.show', compact('product'));
    }

    // **Admin Methods**

    /**
     * Display a listing of the products (for admin).
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product (for admin).
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage (for admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0', // Tambahkan validasi stock
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified product (for admin).
     */
    public function edit(Product $products)
    {
        return view('admin.products.edit', compact('products'));
    }

    /**
     * Update the specified product in storage (for admin).
     */
    public function update(Request $request, Product $products)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
             'stock' => 'required|integer|min:0', // Tambahkan validasi stock
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($products->image); // Hapus kondisi if

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $path;
        }

        $products->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product from storage (for admin).
     */
    public function destroy(Product $products)
    {
        if ($products->image) {
            Storage::disk('public')->delete($products->image);
        }

        $products->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}

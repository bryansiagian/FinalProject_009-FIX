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
    public function showFront(Request $request)
    {
        $searchTerm = $request->input('search');
        $category = $request->input('category'); // Ambil nilai kategori dari request

        $query = Product::query();

        if ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        // Tambahkan filter kategori jika ada
        if ($category) {
            $query->where('category', $category);
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        foreach ($products as $product) {
            $product->load('testimonials.user');
        }

        return view('products.index', compact('products'));
    }

    /**
     * Display the specified product (for guest/customers).
     */
    public function show(Product $product)
    {
        $product->load('testimonials.user');
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
        // Daftar kategori yang valid (sesuai dengan enum di migration)
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan'];
        return view('admin.products.create', compact('categories')); // Kirim data kategori ke view
    }

    /**
     * Store a newly created product in storage (for admin).
     */
    public function store(Request $request)
    {
        // Daftar kategori yang valid (sesuai dengan enum di migration)
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan'];

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'nullable|in:' . implode(',', $categories), // Validasi kategori
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
        // Daftar kategori yang valid (sesuai dengan enum di migration)
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan'];
        return view('admin.products.edit', compact('products', 'categories')); // Kirim data produk dan kategori ke view
    }

    /**
     * Update the specified product in storage (for admin).
     */
    public function update(Request $request, Product $products)
    {
        // Daftar kategori yang valid (sesuai dengan enum di migration)
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan'];

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'nullable|in:' . implode(',', $categories), // Validasi kategori
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($products->image);

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
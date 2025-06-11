<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\KodePos;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // **Public Methods (Guest/Pelanggan)**

    /**
     * Display a listing of the products (for guest/customers).
     */
    public function showFront(Request $request)
{
    $searchTerm = $request->input('search');
    $category = $request->input('category');
    $priceSort = $request->input('price_sort');
    $alphabeticalSort = $request->input('alphabetical_sort');

    $query = Product::query();

    if ($searchTerm) {
        $query->where('name', 'LIKE', '%' . $searchTerm . '%');
    }

    if ($category) {
        $query->where('category', $category);
    }

    if ($priceSort === 'asc') {
        $query->orderBy('price', 'asc');
    } elseif ($priceSort === 'desc') {
        $query->orderBy('price', 'desc');
    }

    if ($alphabeticalSort === 'asc') {
        $query->orderBy('name', 'asc');
    } elseif ($alphabeticalSort === 'desc') {
        $query->orderBy('name', 'desc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $products = $query->select('products.*', DB::raw('(SELECT COALESCE(SUM(order_items.quantity), 0)
                                                        FROM order_items
                                                        JOIN orders ON order_items.order_id = orders.id
                                                        WHERE order_items.product_id = products.id
                                                        AND orders.status = "completed") as total_purchased'))
                      ->paginate(12);

    foreach ($products as $product) {
        $product->load('testimonials.user');
    }

    $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan', 'Tisu', 'Lidi', 'HD', 'Wrapping'];

    return view('products.index', compact('products', 'categories'));
}

    /**
     * Display the specified product (for guest/customers).
     */
    public function show(Product $product)
    {
        $totalPurchased = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.product_id', $product->id)
            ->where('orders.status', 'completed')
            ->sum('order_items.quantity');

        $product->load('testimonials.user');

        $user = Auth::user();
        // $kodePosData = null; // Inisialisasi $kodePosData

        // if ($user) {
        //     $kodePosData = KodePos::where('kode_pos', $user->kode_pos)->first();
        // }

        return view('products.show', compact('product', 'user', 'totalPurchased'));
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
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan', 'Tisu', 'Lidi', 'HD', 'Wrapping'];
        return view('admin.products.create', compact('categories')); // Kirim data kategori ke view
    }

    /**
     * Store a newly created product in storage (for admin).
     */
    public function store(Request $request)
    {
        // Daftar kategori yang valid (sesuai dengan enum di migration)
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan', 'Tisu', 'Lidi', 'HD', 'Wrapping'];

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
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
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan', 'Tisu', 'Lidi', 'HD', 'Wrapping'];
        return view('admin.products.edit', compact('products', 'categories')); // Kirim data produk dan kategori ke view
    }

    /**
     * Update the specified product in storage (for admin).
     */
    public function update(Request $request, Product $products)
    {
        // Daftar kategori yang valid (sesuai dengan enum di migration)
        $categories = ['Kantongan', 'Gelas', 'Sendok', 'Mika', 'Kotak', 'Klip', 'PE', 'PP', 'Kertas', 'Botol', 'Lakban', 'Tali', 'Karet', 'Thinwall', 'Sedotan', 'Tisu', 'Lidi', 'HD', 'Wrapping'];

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
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
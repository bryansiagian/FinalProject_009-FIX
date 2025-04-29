<?php

namespace App\Http\Controllers;

use App\Models\Order; // Ganti dengan model Pesanan Anda
use App\Models\Product;   // Ganti dengan model Produk Anda
use App\Models\Pengumuman; // Ganti dengan model Pengumuman Anda
use App\Models\Galeri;   // Ganti dengan model Galeri Anda
use App\Models\Testimonial; // Ganti dengan model Testimoni Anda
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPesanan = Order::count();
        $jumlahProduk = Product::count();
        $jumlahPengumuman = Pengumuman::count();
        $jumlahGaleri = Galeri::count();
        $jumlahTestimoni = Testimonial::count();

        return view('admin.dashboard', compact(
            'jumlahPesanan',
            'jumlahProduk',
            'jumlahPengumuman',
            'jumlahGaleri',
            'jumlahTestimoni'
        ));
    }
}
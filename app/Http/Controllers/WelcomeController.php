<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Pengumuman;
use App\Models\Galeri;
use App\Models\TentangKami;
use App\Models\Kontak;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $products = Product::all();
        $pengumumen = Pengumuman::all();
        $galeri = Galeri::all();
        $tentang_kami = TentangKami::first(); // Atau cara Anda mengambil data
        $kontak = Kontak::first();

        return view('welcome', compact('products', 'pengumumen', 'galeri', 'tentang_kami', 'kontak'));
    }
}

<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KodePosController;
use App\Http\Controllers\WilayahDesaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

// **Route Publik (Guest/Pelanggan)**
Route::get('/products', [ProductController::class, 'showFront'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/pengumuman', [PengumumanController::class, 'showPengumumanPublic'])->name('pengumuman.public');
Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show'); // Menggunakan show() yang sudah ada
Route::get('/galeri', [GaleriController::class, 'showGaleriPublic'])->name('galeri.public');
Route::get('/tentang-kami', [TentangKamiController::class, 'showFront'])->name('tentang-kami.public');
Route::get('/kontak', [KontakController::class, 'showFront'])->name('kontak.public');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonial.index'); // Daftar Testimoni (Publik)
// Route::post('/kontak/kirim-pesan', [PageController::class, 'kirimPesan'])->name('kirim-pesan'); // Belum ada implementasi

// Authentication Routes (Tidak Perlu Diubah)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Cart Routes (Tidak Perlu Diubah)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Order Routes (Tidak Perlu Diubah)
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // Daftar pesanan (Riwayat Pesanan)
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Testimonial Routes (Pelanggan)
    Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('testimonial.create');
    Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('/testimonial/{testimonial}/edit', [TestimonialController::class, 'editTestimonial'])->name('testimonial.edit');
    Route::put('/testimonial/{testimonial}', [TestimonialController::class, 'updateTestimonial'])->name('testimonial.update');
    Route::delete('/testimonial/{testimonial}', [TestimonialController::class, 'destroyTestimonial'])->name('testimonial.destroy');

});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    // Admin Routes (Gunakan Route::resource untuk yang Sesuai)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/orders/{order}/verify', [AdminController::class, 'verifyOrder'])->name('admin.orders.verify');
    Route::post('/orders/{order}/complete', [AdminController::class, 'completeOrder'])->name('admin.orders.complete');

     // Admin Order Routes (Manually Defined)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
    Route::post('/orders', [AdminOrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Admin Product Routes (Manually Defined)
    Route::get('/product', [ProductController::class, 'index'])->name('admin.products.index'); //Perbaiki
    Route::get('/product/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/product', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/product/{products}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/product/{products}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/product/{products}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // **Galeri (Admin)**
    Route::get('/galeri', [GaleriController::class, 'index'])->name('admin.galeri.index');
    Route::get('/galeri/create', [GaleriController::class, 'create'])->name('admin.galeri.create');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('admin.galeri.store');
    Route::get('/galeri/{galeri}/edit', [GaleriController::class, 'edit'])->name('admin.galeri.edit');
    Route::put('/galeri/{galeri}', [GaleriController::class, 'update'])->name('admin.galeri.update');
    Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');

    // Admin Pengumuman Routes (Manually Defined)
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('admin.pengumuman.index'); // Nama route dibedakan
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('admin.pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
    Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'showAdmin'])->name('admin.pengumuman.show');
    Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('admin.pengumuman.edit');
    Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');

    // Admin Testimonial Routes
    Route::get('/testimonials', [TestimonialController::class, 'testimonials'])->name('admin.testimonials.index');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroyTestimonialAdmin'])->name('admin.testimonials.destroy');
    Route::post('/admin/testimonials/{testimonial}/approve', [TestimonialController::class, 'approveTestimonial'])->name('admin.testimonials.approve');
    Route::post('/admin/testimonials/{testimonial}/reject', [TestimonialController::class, 'rejectTestimonial'])->name('admin.testimonials.reject');

     // **Tentang Kami (Admin)**
    Route::get('/tentang-kami', [TentangKamiController::class, 'index'])->name('admin.tentang-kami.index');
    Route::get('/tentang-kami/create', [TentangKamiController::class, 'create'])->name('admin.tentang-kami.create');
    Route::post('/tentang-kami', [TentangKamiController::class, 'store'])->name('admin.tentang-kami.store');
    Route::get('/tentang-kami/{tentang_kami}/edit', [TentangKamiController::class, 'edit'])->name('admin.tentang-kami.edit');
    Route::put('/tentang-kami/{tentang_kami}', [TentangKamiController::class, 'update'])->name('admin.tentang-kami.update');
    Route::delete('/tentang-kami/{tentang_kami}', [TentangKamiController::class, 'destroy'])->name('admin.tentang-kami.destroy');

    // **Kontak (Admin)**
    Route::get('/kontak', [KontakController::class, 'index'])->name('admin.kontak.index');
    Route::get('/kontak/create', [KontakController::class, 'create'])->name('admin.kontak.create');
    Route::post('/kontak', [KontakController::class, 'store'])->name('admin.kontak.store');
    Route::get('/kontak/{kontak}/edit', [KontakController::class, 'edit'])->name('admin.kontak.edit');
    Route::put('/kontak/{kontak}', [KontakController::class, 'update'])->name('admin.kontak.update');
    Route::delete('/kontak/{kontak}', [KontakController::class, 'destroy'])->name('admin.kontak.destroy');

    // **Kode Pos (Admin)**
    Route::get('kode_pos', [KodePosController::class, 'index'])->name('admin.kode_pos.index');
    Route::get('kode_pos/create', [KodePosController::class, 'create'])->name('admin.kode_pos.create');
    Route::post('kode_pos', [KodePosController::class, 'store'])->name('admin.kode_pos.store');
    Route::get('kode_pos/{kodePos}/edit', [KodePosController::class, 'edit'])->name('admin.kode_pos.edit');
    Route::put('kode_pos/{kodePos}', [KodePosController::class, 'update'])->name('admin.kode_pos.update');
    Route::delete('kode_pos/{kode_pos}', [KodePosController::class, 'destroy'])->name('admin.kode_pos.destroy');

    // **Kode Pos (Admin) - GANTI DENGAN WILAYAH DESA**
    Route::get('/wilayah-desa', [WilayahDesaController::class, 'index'])->name('admin.wilayah-desa.index');
    Route::get('/wilayah-desa/create', [WilayahDesaController::class, 'create'])->name('admin.wilayah-desa.create');
    Route::post('/wilayah-desa', [WilayahDesaController::class, 'store'])->name('admin.wilayah-desa.store');
    Route::get('/wilayah-desa/{wilayahDesa}', [WilayahDesaController::class, 'show'])->name('admin.wilayah-desa.show');
    Route::get('/wilayah-desa/{wilayahDesa}/edit', [WilayahDesaController::class, 'edit'])->name('admin.wilayah-desa.edit');
    Route::put('/wilayah-desa/{wilayahDesa}', [WilayahDesaController::class, 'update'])->name('admin.wilayah-desa.update');
    Route::delete('/wilayah-desa/{wilayahDesa}', [WilayahDesaController::class, 'destroy'])->name('admin.wilayah-desa.destroy');
});
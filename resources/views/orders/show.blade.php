<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')

<!-- Order Detail Section -->
<section class="page-section" id="order-detail" data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" data-aos="fade-down" data-aos-delay="100">
                <div class="card order-card">
                    <div class="card-header">Detail Pesanan #{{ $order->id }}</div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success" data-aos="fade-left" data-aos-delay="200">{{ session('success') }}</div>
                        @endif

                        <div class="order-info" data-aos="fade-right" data-aos-delay="300">
                            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at }}</p>
                            <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Metode Pengiriman:</strong> {{ $order->shipping_method }}</p>
                            <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
                            <p><strong>Status:</strong> {{ $order->status }}</p> <!-- Tambahkan status order -->
                        </div>

                        <h3 class="mt-4" data-aos="fade-up" data-aos-delay="400">Produk yang Dipesan:</h3>

                        <table class="order-items-table" data-aos="zoom-in" data-aos-delay="500">
                            <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                                <th>Aksi</th> <!-- Tambahkan kolom Aksi -->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->orderItems as $orderItem)
                                <tr data-aos="slide-up" data-aos-delay="{{ 100 * $loop->index }}">
                                    <td>
                                        <a href="{{ route('products.show', $orderItem->product->id) }}">{{ $orderItem->product->name }}</a>
                                    </td>
                                    <td>{{ $orderItem->quantity }}</td>
                                    <td>Rp {{ number_format($orderItem->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($orderItem->quantity * $orderItem->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'completed')
                                            <!-- Tombol Tambah Testimoni -->
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#testimonialModal{{ $orderItem->product->id }}">
                                                Beri Testimoni
                                            </button>
                                        @else
                                            Pesanan belum selesai
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3" data-aos="fade-up" data-aos-delay="600">Kembali ke Daftar Pesanan</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@foreach ($order->orderItems as $orderItem)
    <!-- Modal Testimoni -->
    <div class="modal fade" id="testimonialModal{{ $orderItem->product->id }}" tabindex="-1" aria-labelledby="testimonialModalLabel{{ $orderItem->product->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testimonialModalLabel{{ $orderItem->product->id }}">Beri Testimoni untuk {{ $orderItem->product->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @auth
                        @php
                            $testimonial = App\Models\Testimonial::where('user_id', auth()->id())
                                ->where('product_id', $orderItem->product->id)
                                ->first();
                        @endphp

                        @if ($testimonial)
                            <p data-aos="fade-down" data-aos-delay="100">Anda sudah memberikan testimoni untuk produk ini.</p>
                        @else
                            <form action="{{ route('testimonial.store') }}" method="POST" data-aos="fade-up" data-aos-delay="200">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $orderItem->product->id }}">

                                <div class="form-group">
                                    <label for="content">Testimoni:</label>
                                    <textarea class="form-control" id="content" name="content" rows="3" required>{{ old('content') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="rating">Rating (opsional):</label>
                                    <select class="form-control" id="rating" name="rating">
                                        <option value="">Pilih Rating</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Kirim Testimoni</button>
                            </form>
                        @endif
                    @else
                        <p data-aos="fade-down" data-aos-delay="100">Silakan login untuk memberikan testimoni.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Footer-->
@include('layouts.footer')

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sectionId = 'order-detail';
        const navbarHeight = document.querySelector('.navbar').offsetHeight;

        const section = document.getElementById(sectionId);
        if (section) {
            const scrollPosition = section.offsetTop - navbarHeight;

            window.scrollTo({
                top: scrollPosition,
                behavior: 'smooth'
            });
        }
    });
</script>

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 500,
        once: true,
    });
</script>
</body>
</html>
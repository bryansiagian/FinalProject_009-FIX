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
<!-- Portfolio Grid-->
<section class="page-section" id="product-detail" data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" data-aos="zoom-in">
                    <div class="card-header">{{ $product->name }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6" data-aos="fade-right">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            </div>
                            <div class="col-md-6" data-aos="fade-left">
                                <p>{{ $product->description }}</p>
                                <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p><strong>Stok:</strong> {{ $product->stock }}</p>

                                @auth
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST" data-aos="slide-up">
                                        @csrf
                                        <div class="form-group">
                                            <label for="quantity">Jumlah:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                        </div>
                                        <button type="submit" class="btn btn-warning mt-2">
                                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                        </button>
                                    </form>

                                    <a href="{{ route('orders.create') }}" class="btn btn-primary mt-3" data-aos="slide-down">Pesan Sekarang</a>
                                @else
                                    <p data-aos="fade-down">Silakan <a href="{{ route('login') }}">login</a> untuk menambahkan ke keranjang atau memesan.</p>
                                @endauth
                            </div>
                        </div>

                        <hr data-aos="fade-down">

                        <h4 data-aos="fade-right">Testimoni Pelanggan</h4>
                        @if ($product->testimonials->isNotEmpty())
                            @foreach ($product->testimonials as $testimonial)
                                <div class="card mb-3" data-aos="zoom-in" data-aos-delay="{{ 100 * $loop->index }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $testimonial->user->name }}</h5>
                                        <p class="card-text">{{ $testimonial->content }}</p>
                                        @if ($testimonial->rating)
                                            <p class="card-text">Rating: {{ $testimonial->rating }} / 5</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p data-aos="fade-left">Belum ada testimoni untuk produk ini.</p>
                        @endif

                        @auth
                            <h4 data-aos="fade-right">Berikan Testimoni Anda</h4>
                            <form action="{{ route('testimonial.store') }}" method="POST" data-aos="fade-up">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="form-group">
                                    <label for="content">Testimoni:</label>
                                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
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
                        @endauth

                        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3" data-aos="fade-down">Kembali ke Daftar Produk</a> <!-- Tombol Kembali -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer-->
@include('layouts.footer')

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sectionId = 'product-detail';
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
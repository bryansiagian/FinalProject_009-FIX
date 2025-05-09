<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')
<!-- Portfolio Grid-->
<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $product->name }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <p>{{ $product->description }}</p>
                                <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p><strong>Stok:</strong> {{ $product->stock }}</p>

                                @auth
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="quantity">Jumlah:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                        </button>
                                    </form>

                                    <a href="{{ route('orders.create') }}" class="btn btn-success mt-3">Pesan Sekarang</a>
                                @else
                                    <p>Silakan <a href="{{ route('login') }}">login</a> untuk menambahkan ke keranjang atau memesan.</p>
                                @endauth
                            </div>
                        </div>

                        <hr>

                        <h4>Testimoni Pelanggan</h4>
                        @if ($product->testimonials->isNotEmpty())
                            @foreach ($product->testimonials as $testimonial)
                                <div class="card mb-3">
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
                            <p>Belum ada testimoni untuk produk ini.</p>
                        @endif

                        @auth
                            <h4>Berikan Testimoni Anda</h4>
                            <form action="{{ route('testimonial.store') }}" method="POST">
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

                                <button type="submit" class="btn btn-primary">Kirim Testimoni</button>
                            </form>
                        @endauth
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
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<!-- * *                               SB Forms JS                               * *-->
<!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
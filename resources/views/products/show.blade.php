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

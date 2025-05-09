<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')

<!-- Portfolio Grid-->
<section class="page-section" id="products">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Produk Kami</h2>
            <h3 class="section-subheading text-muted">Produk-produk plastik berkualitas tinggi untuk kebutuhan Anda.</h3>
        </div>

        <div class="row mb-4 justify-content-center">
            <div class="col-md-8 col-lg-6">
                {{-- Pastikan route() mengarah ke route yang memanggil ProductController@showFront --}}
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari nama produk..." value="{{ request('search') }}" aria-label="Cari Produk">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> <span class="d-none d-md-inline">Cari</span>
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                            <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            <div class="product-actions d-flex flex-column align-items-start">
                                @auth
                                    <!-- Form Tambah ke Keranjang -->
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <div class="form-group">
                                            <label for="quantity">Jumlah:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-sm btn-secondary w-100 mb-2">
                                            <i class="fas fa-shopping-cart"></i> Keranjang
                                        </button>
                                    </form>

                                    <!-- Tombol "Beli Sekarang" (Memicu Modal) -->
                                    <a href="#" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#shippingOptionsModal{{ $product->id }}">
                                        <i class="fas fa-shopping-basket"></i> Beli Sekarang
                                    </a>

                                    <!-- Modal Pilihan Pengiriman -->
                                    {{-- @include('layouts.modal.order') --}}
                                @else
                                    {{-- <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login</a> --}}
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                @include('layouts.modal.order')

                <!-- Modal -->
                @include('layouts.modal.product')
            @endforeach
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
        const sectionId = 'products';
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
</body>
</html>


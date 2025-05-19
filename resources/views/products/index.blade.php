<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <!-- Tambahkan ini di file layouts.head atau langsung di sini -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
<header class="masthead" data-aos="fade-down">
    <div class="container">
        <div class="masthead-content">
            <h1 class="masthead-heading text-uppercase">HARMONIS PLASTIK</h1>
        </div>
    </div>
</header>

<!-- Portfolio Grid-->
<section class="page-section" id="products" data-aos="fade-up">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Produk Kami</h2>
            <h3 class="section-subheading text-muted">Produk-produk plastik berkualitas tinggi untuk kebutuhan Anda.</h3>
        </div>

        <div class="row mb-4 justify-content-center">
            <div class="col-md-8 col-lg-6">
                {{-- Pastikan route() mengarah ke route yang memanggil ProductController@showFront --}}
                <form action="{{ route('products.index') }}" method="GET" class="d-flex" data-aos="fade-up" data-aos-delay="100">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari nama produk..." value="{{ request('search') }}" aria-label="Cari Produk">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> <span class="d-none d-md-inline">Cari</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Filter Kategori --}}
        <div class="row mb-3 justify-content-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group">
                        <select class="form-select" name="category" aria-label="Pilih Kategori" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $kategori)
                                <option value="{{ strtolower($kategori) }}" {{ request('category') == strtolower($kategori) ? 'selected' : '' }}>
                                    {{ ucfirst($kategori) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="search" value="{{ request('search') }}">
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success" data-aos="fade-up" data-aos-delay="300">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="300">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @php
                $productRows = $products->chunk(4);
            @endphp

            @foreach($productRows as $row)
                <div class="product-row row" data-aos="fade-up" data-aos-delay="{{ 100 * $loop->index }}">
                    @foreach($row as $product)
                        <div class="col-md-3 mb-4 product-item">
                            <div class="card product-card">
                                {{-- Mengarahkan ke halaman detail produk --}}
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                                    <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                                    {{-- Hapus tombol keranjang dan beli sekarang di sini --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
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
<script>
    AOS.init({
        duration: 1000,
        once: true,
    });
</script>
</body>
</html>
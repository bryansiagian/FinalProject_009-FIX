@extends('layouts.app')

@section('title', 'Produk | Harmonis Plastik')

@section('content')
<!-- Portfolio Grid-->
<section class="page-section" id="products" data-aos="fade-up">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Produk Kami</h2>
            <h3 class="section-subheading text-muted">Produk-produk plastik berkualitas tinggi untuk kebutuhan Anda.</h3>
        </div>

        {{-- Search and Filter Row --}}
        <div class="row mb-4 justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">

                    {{-- Search Form --}}
                    <form action="{{ route('products.index') }}" method="GET" class="flex-grow-1 me-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}" aria-label="Cari Produk">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> <span class="d-none d-md-inline">Cari</span>
                            </button>
                        </div>
                    </form>

                    {{-- Filter Button --}}
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterOptions" aria-expanded="false" aria-controls="filterOptions">
                        Filter <i class="fas fa-filter"></i>
                    </button>

                </div>
            </div>
        </div>

        {{-- Collapsible Filter Options --}}
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="collapse" id="filterOptions">
                    <div class="card card-body">
                        <form action="{{ route('products.index') }}" method="GET" class="row gy-2">
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            <div class="col-md-6">
                                <label for="category" class="form-label">Kategori:</label>
                                <select class="form-select" name="category" id="category" aria-label="Pilih Kategori" onchange="this.form.submit()">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $kategori)
                                        <option value="{{ strtolower($kategori) }}" {{ request('category') == strtolower($kategori) ? 'selected' : '' }}>
                                            {{ ucfirst($kategori) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="price_sort" class="form-label">Urutkan Harga:</label>
                                <select class="form-select" name="price_sort" id="price_sort" aria-label="Urutkan Harga" onchange="this.form.submit()">
                                    <option value="">Tidak Diurutkan</option>
                                    <option value="asc" {{ request('price_sort') == 'asc' ? 'selected' : '' }}>Termurah Dulu</option>
                                    <option value="desc" {{ request('price_sort') == 'desc' ? 'selected' : '' }}>Termahal Dulu</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="alphabetical_sort" class="form-label">Urutkan Abjad:</label>
                                <select class="form-select" name="alphabetical_sort" id="alphabetical_sort" aria-label="Urutkan Abjad" onchange="this.form.submit()">
                                    <option value="">Tidak Diurutkan</option>
                                    <option value="asc" {{ request('alphabetical_sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                                    <option value="desc" {{ request('alphabetical_sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
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

            AOS.init({
                duration: 1000,
                once: true,
            });
        });
    </script>
@endsection
<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar-welcome')

<!-- Masthead-->
<header class="masthead" id="header">
    <div class="container">
        <br><br>
        {{-- <div class="masthead-subheading">Selamat Datang di</div> --}}
        <div class="masthead-heading text-uppercase">HARMONIS PLASTIK</div>
    </div>
</header>

<!-- Why Choose Us Section -->
<section class="page-section" id="why-choose-us">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Mengapa Memilih Kami?</h2>
            <p class="section-subheading text-muted">Kami menawarkan solusi terbaik untuk kebutuhan Anda.</p>
        </div>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="feature-card-container">
                    <div class="feature-card">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x secondary"></i>
                            <i class="fa-solid fa-box-open fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="feature-title">Kualitas Terbaik</h4>
                        <p class="feature-description">Kami hanya menawarkan produk dan layanan berkualitas tinggi yang telah teruji dan terbukti.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card-container">
                    <div class="feature-card">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x secondary"></i>
                            <i class="fa-solid fa-handshake fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="feature-title">Dukungan Pelanggan 24/7</h4>
                        <p class="feature-description">Tim dukungan pelanggan kami siap membantu Anda 24 jam sehari, 7 hari seminggu.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card-container">
                    <div class="feature-card">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x secondary"></i>
                            <i class="fa-solid fa-layer-group fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="feature-title">Banyak Pilhan</h4>
                        <p class="feature-description">Kami menyediakan berbagai jenis plastik untuk kebutuhan rumah tangga, bisnis, dan industri.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Grid-->
<section class="page-section bg-white" id="products">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Produk Kami</h2>
            <h3 class="section-subheading text-muted">Produk-produk plastik berkualitas tinggi untuk kebutuhan Anda.</h3>
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
            @foreach($products->take(4) as $product)  <!-- Menampilkan hanya 4 produk pertama -->
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
         <div class="text-center">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Semua Produk</a>
        </div>
    </div>
</section>

<!-- Pengumuman Section-->
<section class="page-section bg-white" id="pengumuman">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Pengumuman</h2>
            <h3 class="section-subheading text-muted">Informasi terbaru dari kami.</h3>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            @if(count($pengumumen) > 0)
                @foreach ($pengumumen->take(3) as $pengumuman) <!-- Menampilkan hanya 3 pengumuman pertama -->
                    <div class="col-md-4 mb-4">
                        <div class="card pengumuman-card" data-bs-toggle="modal" data-bs-target="#pengumumanModal{{ $pengumuman->id }}" style="cursor: pointer;">
                            @if($pengumuman->gambar)
                                <img src="{{ asset('storage/pengumuman/' . $pengumuman->gambar) }}" class="card-img-top" alt="{{ $pengumuman->judul }}"
                                     style="height: 275px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/400x275" class="card-img-top" alt="Placeholder"
                                     style="height: 275px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $pengumuman->judul }}</h5>
                                <p class="card-text">{!! Str::limit($pengumuman->isi, 100) !!}</p> <!-- Batasi tampilan awal -->
                                <p>Dibuat pada: {{ $pengumuman->created_at->format('d M Y H:i') }}</p>
                                <p>Terakhir diperbarui: {{ $pengumuman->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Pengumuman -->
                    @include('layouts.modal.pengumuman')
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada pengumuman saat ini.</p>
                </div>
            @endif
        </div>
         <div class="text-center">
            <a href="{{ route('pengumuman.public') }}" class="btn btn-primary">Lihat Semua Pengumuman</a>
        </div>
    </div>
</section>

<!-- Galeri Section-->
<section class="page-section bg-white" id="galeri">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Galeri</h2>
            <p class="text-muted">Koleksi gambar kami.</p>
        </div>
        <div class="row">
            @forelse($galeri->take(6) as $gambar) <!-- Menampilkan hanya 6 gambar pertama -->
                <div class="col-md-4 mb-4">
                    <div class="card galeri-card">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#galeriModal{{ $gambar->id }}">
                            <img src="{{ asset('storage/' . $gambar->path) }}" class="card-img-top" alt="{{ $gambar->nama_gambar }}">
                        </a>
                    </div>
                </div>

                <!-- Modal Galeri -->
                @include('layouts.modal.galeri')
            @empty
                <div class="col-md-12">
                    <p class="text-muted text-center">Belum ada gambar di galeri.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center">
            <a href="{{ route('galeri.public') }}" class="btn btn-primary">Lihat Semua Gambar</a>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section id="tentangkami" class="page-section bg-white">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Tentang Kami</h2>
            <p class="mb-4 text-muted">Kenali lebih dekat siapa kami dan apa yang kami perjuangkan.</p>
            <div class="divider-custom">
                <div class="divider-line"></div>
                <div class="divider-icon"><i class="fas fa-star"></i></div>
                <div class="divider-line"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if($tentang_kami)
                    <div class="card about-card">
                        <div class="about-card-body">
                            <div class="about-content">
                                <h3>{{ $tentang_kami->nama_toko }}</h3>
                                <div>
                                    <h4>Alamat:</h4>
                                    <p>{!! $tentang_kami->alamat !!}</p>
                                </div>
                                <div>
                                    <h4>Sejarah:</h4>
                                    <p>{!! $tentang_kami->sejarah !!}</p>
                                </div>
                                <div>
                                    <h4>Deskripsi:</h4>
                                    <p>{!! $tentang_kami->deskripsi !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada informasi tentang toko.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Kontak Section -->
<section class="page-section bg-white" id="kontak">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Kontak Kami</h2>
            <h3 class="section-subheading text-muted">Hubungi kami untuk informasi lebih lanjut.</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card contact-card">
                    <div class="contact-card-body">
                        <div class="row">
                            <div class="col-md-6 contact-info">
                                <h3>Informasi Kontak</h3>
                                @if($kontak)
                                    <p><strong>Alamat:</strong> {!! $kontak->alamat !!}</p>
                                    <p><strong>Telepon:</strong> {{ $kontak->telepon }}</p>
                                    <p><strong>Email:</strong> {{ $kontak->email }}</p>
                                @else
                                    <p class="text-muted">Belum ada informasi kontak.</p>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h3>Peta</h3>
                                <!-- Ganti dengan kode embed Google Maps Anda -->
                                @if($kontak)
                                    <div class="map-container">
                                        {!! $kontak->peta !!}
                                    </div>
                                @else
                                    <p class="text-muted">Belum ada informasi Peta.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer-->
@include('admin.footer')

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts.js') }}"></script>

<script>
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('#mainNav');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                window.scrollTo({
                    top: targetElement.offsetTop - navbarHeight,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
</body>
</html>

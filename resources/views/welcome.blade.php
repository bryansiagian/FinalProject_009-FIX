<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <!-- Tambahkan ini di file layouts.head atau langsung di sini -->
</head>

<body id="page-top">
    <!-- Navigation-->
    @include('layouts.navbar-welcome')

    <!-- Alert -->
    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Masthead-->
    @include('layouts.header')

    <!-- Why Choose Us Section -->
    <section class="page-section bg-light" id="why-choose-us" data-aos="fade-up">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Mengapa Memilih Kami?</h2>
                <p class="section-subheading text-muted">Kami menawarkan solusi terbaik untuk kebutuhan Anda.</p>
            </div>
            <div class="row text-center">
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
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
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
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
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
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

    <!-- Produk -->
    <!-- Produk -->
    <section class="page-section bg-light" id="products">
        <div class="container" data-aos="fade-up">
            <div class="text-center">
                <h2 class="mt-0 section-heading text-uppercase">Produk Kami</h2>
                <h3 class="section-subheading text-muted">Produk-produk plastik berkualitas tinggi untuk kebutuhan Anda.</h3>
            </div>

            <div class="row">
                @foreach($products->take(4) as $index => $product)
                    <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="{{ 100 * $loop->index }}">
                        <div class="card-container"> <!-- Bungkus dengan card-container -->
                            <div class="card product-card">
                                {{-- Arahkan ke halaman detail produk --}}
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                                    <p class="card-text">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Lihat Semua Produk</a>
            </div>
        </div>
    </section>

    <!-- Pengumuman -->
    <section class="page-section bg-light" id="pengumuman">
        <div class="container" data-aos="fade-up">
            <div class="text-center">
                <h2 class="mt-0 section-heading text-uppercase">Pengumuman</h2>
                <h3 class="section-subheading text-muted">Informasi terbaru dari kami.</h3>
            </div>

            <div class="row">
                @foreach ($pengumumen->take(3) as $pengumuman)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ 100 * $loop->index }}">
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
                                <p class="card-text">{!! Str::limit($pengumuman->isi, 100) !!}</p>
                                <p>Dibuat pada: {{ $pengumuman->created_at->format('d M Y H:i') }}</p>
                                <p>Terakhir diperbarui: {{ $pengumuman->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    @include('layouts.modal.pengumuman')
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('pengumuman.public') }}" class="btn btn-primary">Lihat Semua Pengumuman</a>
            </div>
        </div>
    </section>

    <!-- Galeri -->
    <section class="page-section bg-light" id="galeri" >
        <div class="container" data-aos="fade-up">
            <div class="text-center">
                <h2 class="mt-0 section-heading text-uppercase">Galeri</h2>
                <p class="text-muted">Koleksi gambar kami.</p>
            </div>
            <div class="row">
                @foreach($galeri->take(6) as $gambar)
                     <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ 100 * $loop->index }}">
                        <div class="card galeri-card">
                            <img src="{{ asset('storage/' . $gambar->path) }}" class="card-img-top" alt="{{ $gambar->nama_gambar }}">
                            <div class="overlay">
                                <h5>{{ $gambar->nama_gambar }}</h5>
                                <p>{{ $gambar->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('galeri.public') }}" class="btn btn-primary">Lihat Semua Gambar</a>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="tentangkami" class="page-section bg-white" >
        <div class="container" data-aos="fade-up">
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
                                    <h4>Alamat:</h4>
                                    <p>{!! $tentang_kami->alamat !!}</p>
                                    <h4>Sejarah:</h4>
                                    <p>{!! $tentang_kami->sejarah !!}</p>
                                    <h4>Deskripsi:</h4>
                                    <p>{!! $tentang_kami->deskripsi !!}</p>
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

        <!-- Kode Pos -->
        <section class="page-section bg-white" id="kodepos">
            <div class="container" data-aos="fade-up">
                <div class="text-center">
                    <h2 class="mt-0 section-heading text-uppercase">Kode Pos</h2>
                    <h3 class="section-subheading text-muted">Daftar kode pos dan ongkos kirim yang berlaku.</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kode Pos</th>
                                                <th>Ongkos Kirim</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($kodepos->isNotEmpty())
                                                @foreach($kodepos as $item)
                                                    <tr>
                                                        <td>{{ $item->kode_pos }}</td>
                                                        <td>Rp {{ number_format($item->ongkos_kirim, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2" class="text-center">Tidak ada data kode pos.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- Kontak -->
    <section class="page-section bg-white" id="kontak">
        <div class="container" data-aos="fade-up">
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
                                    @if($kontak)
                                        <div class="map-container">{!! $kontak->peta !!}</div>
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
    
    <!-- Footer -->
    @include('admin.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });

        window.addEventListener('scroll', function () {
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

        // Auto close alert after 3 seconds
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 3000);
    </script>
</body>
</html>
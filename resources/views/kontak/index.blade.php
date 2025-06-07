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

<!-- Kontak Section -->
<section class="page-section" id="kontak" data-aos="fade-up">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Kontak Kami</h2>
            <h3 class="section-subheading text-muted">Hubungi kami untuk informasi lebih lanjut.</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-down" data-aos-delay="100">
                <div class="card contact-card">
                    <div class="contact-card-body">
                        @if($kontak->count() > 0)
                            @foreach($kontak as $itemKontak)
                                <div class="row">
                                    <div class="col-md-6 contact-info" data-aos="fade-right" data-aos-delay="200">
                                        <h3>Informasi Kontak</h3>
                                        <p><strong>Alamat:</strong> {!! $itemKontak->alamat !!}</p>
                                        <p><strong>Telepon:</strong> {{ $itemKontak->telepon }}</p>
                                        <p><strong>Email:</strong> {{ $itemKontak->email }}</p>

                                        <!-- Formulir Kontak (Opsional) -->
                                        {{-- <form action="{{ route('kirim-pesan') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pesan" class="form-label">Pesan</label>
                                                <textarea class="form-control" id="pesan" name="pesan" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                                        </form> --}}
                                    </div>

                                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                                        <h3>Peta</h3>
                                        <!-- Ganti dengan kode embed Google Maps Anda -->
                                        <div class="map-container">
                                            {!! $itemKontak->peta !!}
                                        </div>
                                    </div>
                                </div>
                                <hr> {{-- Tambahkan pemisah antar kontak --}}
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada informasi kontak.</p>
                        @endif
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
        const sectionId = 'kontak';
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
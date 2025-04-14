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

<!-- Kontak Section -->
<section class="page-section" id="kontak">
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
</body>
</html>
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

<!-- Pengumuman Section-->
<section class="page-section" id="pengumuman-detail" data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card pengumuman-card">
                    @if($pengumuman->gambar)
                        <img src="{{ asset('storage/pengumuman/' . $pengumuman->gambar) }}" class="card-img-top" alt="{{ $pengumuman->judul }}"
                             style="height: 400px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $pengumuman->judul }}</h2>
                        <p class="card-text">{!! $pengumuman->isi !!}</p>
                        <p>Dibuat pada: {{ $pengumuman->created_at->format('d M Y H:i') }}</p>
                        <p>Terakhir diperbarui: {{ $pengumuman->updated_at->format('d M Y H:i') }}</p>
                        <a href="{{ route('pengumuman.public') }}" class="btn btn-secondary">Kembali ke Daftar Pengumuman</a>
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
        const sectionId = 'pengumuman-detail';
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
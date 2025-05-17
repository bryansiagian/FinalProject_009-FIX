<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .card-link {
    text-decoration: none; /* Menghilangkan garis bawah default pada link */
    color: inherit; /* Menggunakan warna teks dari elemen induk */
}

.card-link:hover {
    text-decoration: none; /* Menghilangkan garis bawah saat di-hover */
    color: inherit; /* Menggunakan warna teks dari elemen induk saat di-hover */
}
    </style>
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')

<!-- Pengumuman Section-->
<section class="page-section" id="pengumuman" data-aos="fade-up">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Pengumuman</h2>
            <h3 class="section-subheading text-muted">Informasi terbaru dari kami.</h3>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success" data-aos="fade-down" data-aos-delay="100">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            @if(count($pengumumen) > 0)
                @foreach ($pengumumen as $pengumuman)
                    <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="{{ 100 * $loop->index }}">
                        <a href="{{ route('pengumuman.show', $pengumuman->id) }}" class="card-link">
                            <div class="card pengumuman-card">
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
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-muted">Tidak ada pengumuman saat ini.</p>
                </div>
            @endif
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
        const sectionId = 'pengumuman';
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
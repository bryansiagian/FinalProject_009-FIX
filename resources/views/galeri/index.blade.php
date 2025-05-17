<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .galeri-card {
            position: relative;
            overflow: hidden;
        }

        .galeri-card .card-img-top {
            transition: transform 0.3s ease-in-out;
            height: 250px;
            object-fit: cover;
        }

        .galeri-card:hover .card-img-top {
            transform: scale(1.1);
        }

        .galeri-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            padding: 10px;
            text-align: center;
        }

        .galeri-card:hover .overlay {
            opacity: 1;
        }

        .galeri-card .overlay h5 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .galeri-card .overlay p {
            font-size: 1rem;
        }
    </style>
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')

<!-- Galeri Section-->
<section class="page-section" id="galeri" data-aos="fade-up">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Galeri</h2>
            <p class="text-muted">Koleksi gambar kami.</p>
        </div>
        <div class="row">
            @forelse($galeri as $gambar)
                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="{{ 100 * $loop->index }}">
                    <div class="card galeri-card">
                        <img src="{{ asset('storage/' . $gambar->path) }}" class="card-img-top" alt="{{ $gambar->nama_gambar }}">
                        <div class="overlay">
                            <h5>{{ $gambar->nama_gambar }}</h5>
                            <p>{{ $gambar->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12" data-aos="fade-down" data-aos-delay="200">
                    <p class="text-muted text-center">Belum ada gambar di galeri.</p>
                </div>
            @endforelse
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
        const sectionId = 'galeri';
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
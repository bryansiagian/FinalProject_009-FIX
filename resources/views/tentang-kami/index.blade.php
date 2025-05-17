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

<!-- About Us Section -->
<section id="tentangkami" class="page-section" data-aos="fade-up">
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
            <div class="col-lg-8" data-aos="fade-down" data-aos-delay="100">
                @if($tentang_kami)
                    <div class="card about-card" data-aos="zoom-in" data-aos-delay="200">
                        <div class="about-card-body">
                            <div class="about-content">
                                <h3>{{ $tentang_kami->nama_toko }}</h3>
                                <div data-aos="fade-right" data-aos-delay="300">
                                    <h4>Alamat:</h4>
                                    <p>{!! $tentang_kami->alamat !!}</p>
                                </div>
                                <div data-aos="fade-left" data-aos-delay="400">
                                    <h4>Sejarah:</h4>
                                    <p>{!! $tentang_kami->sejarah !!}</p>
                                </div>
                                <div data-aos="fade-right" data-aos-delay="500">
                                    <h4>Deskripsi:</h4>
                                    <p>{!! $tentang_kami->deskripsi !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted text-center" data-aos="fade-up" data-aos-delay="300">Belum ada informasi tentang toko.</p>
                @endif
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
        const sectionId = 'tentangkami';
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
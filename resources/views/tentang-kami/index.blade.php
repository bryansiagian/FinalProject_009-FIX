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

<!-- About Us Section -->
<section id="tentangkami" class="page-section">
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
</body>
</html>
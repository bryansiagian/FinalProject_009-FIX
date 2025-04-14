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
<!-- Footer-->
@include('layouts.footer')
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
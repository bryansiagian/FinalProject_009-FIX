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

<!-- Galeri Section-->
<section class="page-section" id="galeri">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Galeri</h2>
            <p class="text-muted">Koleksi gambar kami.</p>
        </div>
        <div class="row">
            @forelse($galeri as $gambar)
                <div class="col-md-4 mb-4">
                    <div class="card galeri-card">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#galeriModal{{ $gambar->id }}">
                            <img src="{{ asset('storage/' . $gambar->path) }}" class="card-img-top" alt="{{ $gambar->nama_gambar }}">
                        </a>
                    </div>
                </div>

                <!-- Modal Galeri -->
                <div class="modal fade" id="galeriModal{{ $gambar->id }}" tabindex="-1" aria-labelledby="galeriModalLabel{{ $gambar->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="galeriModalLabel{{ $gambar->id }}">{{ $gambar->nama_gambar }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('storage/' . $gambar->path) }}" class="img-fluid mb-3" alt="{{ $gambar->nama_gambar }}">
                                <p>{{ $gambar->deskripsi }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
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
</body>
</html>
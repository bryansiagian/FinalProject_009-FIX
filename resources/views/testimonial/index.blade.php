<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <title>Testimoni Pelanggan</title>
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')
<!-- Testimoni Section-->
<section class="page-section" id="testimonials">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Testimoni Pelanggan</h2>
            <h3 class="section-subheading text-muted">Apa yang pelanggan kami katakan tentang kami.</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @auth
                    <div class="text-center mb-4">
                        <a href="{{ route('testimonial.create') }}" class="btn btn-primary">Berikan Testimoni</a>
                    </div>
                @else
                    <div class="text-center mb-4">
                        <p>Ingin memberikan testimoni? <a href="{{ route('login') }}">Login</a> terlebih dahulu.</p>
                    </div>
                @endauth

                @if ($testimonials->count() > 0)
                    @foreach ($testimonials as $testimonial)
                        <div class="card testimonial-card mb-4">
                            <div class="card-body">
                                <p class="card-text">{!! nl2br(e($testimonial->content)) !!}</p>
                                <p class="testimonial-author">- {{ $testimonial->user->name }}</p>
                                @if ($testimonial->rating)
                                    <p class="testimonial-rating">
                                        @for ($i = 0; $i < $testimonial->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </p>
                                @endif

                                <!-- Tombol Edit dan Hapus (hanya untuk pemilik testimoni) -->
                                @auth
                                @if (Auth::user()->id == $testimonial->user_id)
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('testimonial.edit', $testimonial->id) }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                        <form action="{{ route('testimonial.destroy', $testimonial->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $testimonials->links() }} <!-- Menampilkan link pagination di tengah -->
                    </div>
                @else
                    <p class="text-center text-muted">Belum ada testimoni yang tersedia.</p>
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
        const sectionId = 'testimonials';
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
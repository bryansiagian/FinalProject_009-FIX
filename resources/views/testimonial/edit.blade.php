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

<!-- Edit Testimonial Section -->
<section class="page-section" id="edit-testimonial">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card testimonial-form-card">
                    <div class="card-header">Edit Testimoni</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('testimonial.update', $testimonial) }}">
                            @csrf
                            @method('PUT') <!-- Penting: Menggunakan method PUT -->

                            <div class="mb-3">
                                <label for="content" class="form-label">Testimoni Anda</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content', $testimonial->content) }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rating (Opsional)</label>
                                <div class="rating-options">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="rating-option">
                                            <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'checked' : '' }}>
                                            <label for="rating{{ $i }}"><i class="fas fa-star"></i></label>
                                        </div>
                                    @endfor
                                </div>
                                @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('testimonial.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
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
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
<!-- Keranjang Section-->
<section class="page-section" id="keranjang" data-aos="fade-up">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Keranjang Belanja</h2>
            <h3 class="section-subheading text-muted">Periksa item di keranjang Anda sebelum melanjutkan.</h3>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-down" data-aos-delay="100">
                <div class="cart-card">
                    <div class="cart-card-body">

                        @if(session('success'))
                            <div class="alert alert-success" data-aos="fade-left" data-aos-delay="200">{{ session('success') }}</div>
                        @endif

                        @if(session('warning'))
                            <div class="alert alert-warning" data-aos="fade-right" data-aos-delay="200">{{ session('warning') }}</div>
                        @endif

                        @if($cartItems->count() > 0)
                            <table class="cart-table" data-aos="zoom-in" data-aos-delay="300">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr data-aos="slide-up" data-aos-delay="{{ 100 * $loop->index }}">
                                            <td class="cart-item-name">{{ $item->product->name }}</td>
                                            <td class="cart-item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-group">
                                                        <input type="number" class="form-control form-control-sm cart-item-quantity" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-success btn-sm btn-update">Update</button>
                                                </form>
                                            </td>
                                            <td class="cart-item-total">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="cart-actions">
                                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm btn-remove">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr data-aos="fade-down" data-aos-delay="400">
                            <div class="checkout-button" data-aos="fade-up" data-aos-delay="500">
                                <a href="{{ route('orders.create') }}" class="btn btn-primary">Checkout</a>
                            </div>
                        @else
                            <p class="cart-empty-message" data-aos="fade-down" data-aos-delay="400">Keranjang Anda kosong.</p>
                        @endif
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
        const sectionId = 'keranjang';
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
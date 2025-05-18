<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')
<!-- Portfolio Grid-->
<section class="page-section" id="product-detail">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $product->name }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <p>{{ $product->description }}</p>
                                <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p><strong>Stok:</strong> {{ $product->stock }}</p>

                                @auth
                                    <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="quantity">Jumlah:</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                        </div>
                                        <button type="submit" class="btn btn-warning mt-2" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                        </button>
                                    </form>

                                    <!-- Tombol Pesan Sekarang (Modal) -->
                                    @if ($product->stock > 0)
                                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#orderModal">
                                            Pesan Sekarang
                                        </button>
                                    @else
                                        <p class="text-danger mt-3">Stok Habis</p>
                                    @endif

                                @else
                                    <p>Silakan <a href="{{ route('login') }}">login</a> untuk menambahkan ke keranjang atau memesan.</p>
                                @endauth
                            </div>
                        </div>

                        <hr>

                        <h4>Testimoni Pelanggan</h4>
                        @if ($product->testimonials->isNotEmpty())
                            @foreach ($product->testimonials as $testimonial)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $testimonial->user->name }}</h5>
                                        <p class="card-text">{{ $testimonial->content }}</p>
                                        @if ($testimonial->rating)
                                            <p class="card-text">Rating: {{ $testimonial->rating }} / 5</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Belum ada testimoni untuk produk ini.</p>
                        @endif

                        @auth
                            @php
                                $hasPurchased = App\Models\Order::where('user_id', auth()->id())
                                    ->whereHas('orderItems', function ($query) use ($product) {
                                        $query->where('product_id', $product->id);
                                    })
                                    ->where('status', 'completed')
                                    ->exists();

                                $testimonial = App\Models\Testimonial::where('user_id', auth()->id())
                                    ->where('product_id', $product->id)
                                    ->first(); // Ambil testimoni user yang login
                            @endphp

                            @if($hasPurchased && !$testimonial)
                                <!-- Form Buat Testimoni -->
                                <h4>Berikan Testimoni Anda</h4>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form action="{{ route('testimonial.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="form-group">
                                        <label for="content">Testimoni:</label>
                                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="rating">Rating (opsional):</label>
                                        <select class="form-control" id="rating" name="rating">
                                            <option value="">Pilih Rating</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Kirim Testimoni</button>
                                </form>
                            @elseif(!$hasPurchased)
                                <p>Anda harus membeli produk ini terlebih dahulu untuk memberikan testimoni.</p>
                            @elseif($testimonial)
                                <p>Anda sudah memberikan testimoni untuk produk ini.</p>
                            @endif
                        @else
                            <p>Silakan melakukan <a href="{{ route('login') }}">pemesanan</a> untuk memberikan testimoni.</p>
                        @endauth

                        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Produk</a> <!-- Tombol Kembali -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Formulir Pemesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @auth
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="shipping_method" id="shipping_method" value="{{ $kodePosData ? 'delivery' : 'self_pickup' }}">

                            <div class="form-group">
                                <label for="quantity">Jumlah:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" required>
                            </div>

                            <div id="address_fields">
                                <div class="form-group">
                                    <label for="address">Alamat Pengiriman:</label>
                                    <textarea class="form-control" id="address" name="shipping_address" rows="3" required>{{ $user->shipping_address }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Kode Pos:</label>
                                    <input type="text" class="form-control" value="{{ $user->kode_pos }}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Metode Pengiriman:</label>
                                @if($kodePosData)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="shipping_option" id="delivery" value="delivery" checked onchange="updateShippingMethod('delivery')">
                                        <label class="form-check-label" for="delivery">
                                            Delivery (Rp {{ number_format($kodePosData->ongkos_kirim, 0, ',', '.') }})
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="shipping_option" id="self_pickup" value="self_pickup" onchange="updateShippingMethod('self_pickup')">
                                        <label class="form-check-label" for="self_pickup">
                                            Self Pick-up
                                        </label>
                                    </div>
                                @else
                                    <p>Kode pos tidak terdaftar. Hanya tersedia Self Pick-up.</p>
                                    <input type="hidden" name="shipping_option" value="self_pickup">
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Proses Pemesanan</button>
                        </form>
                    @else
                        <p>Silakan melakukan <a href="{{ route('login') }}">pemesanan</a> untuk memberikan testimoni.</p>
                    @endauth
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
        const sectionId = 'product-detail';
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

    function updateShippingMethod(method) {
        document.getElementById('shipping_method').value = method;
        var addressFields = document.getElementById('address_fields');

        if (method === 'self_pickup') {
            addressFields.style.display = 'none';
        } else {
            addressFields.style.display = 'block';
        }
    }
</script>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
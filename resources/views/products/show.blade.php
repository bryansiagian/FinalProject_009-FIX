@extends('layouts.app')

@section('title', $product->name . ' | Harmonis Plastik')

@section('content')
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
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <p>{{ $product->description }}</p>
                                    <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p><strong>Stok:</strong> {{ $product->stock }}</p>
                                    <p><strong>Terjual:</strong> {{ $totalPurchased }}</p>

                                    @auth
                                        <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="quantity">Jumlah:</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                    value="1" min="1" max="{{ $product->stock }}">
                                            </div>
                                            <button type="submit" class="btn btn-warning mt-2"
                                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                            </button>
                                        </form>

                                        <!-- Tombol Pesan Sekarang (Modal) -->
                                        @if ($product->stock > 0)
                                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                                data-bs-target="#shippingOptionsModal{{ $product->id }}">
                                                Pesan Sekarang
                                            </button>
                                        @else
                                            <p class="text-danger mt-3">Stok Habis</p>
                                        @endif
                                    @else
                                        <p>Silakan <a href="{{ route('login') }}">login</a> untuk menambahkan ke keranjang
                                            atau memesan.</p>
                                    @endauth
                                </div>
                            </div>

                            <hr>

                            <h4>Testimoni Pelanggan</h4>

                            <div class="row">
                                <!-- Kode Testimoni Anda di Sini -->
                                <!-- Pastikan Kode Testimoni Ada Di Sini -->
                            </div>

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

                                @if ($hasPurchased)
                                    @if (!$testimonial)
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
                                                <label for="content-{{ $product->id }}">Testimoni:</label>
                                                <textarea class="form-control" id="content-{{ $product->id }}" name="content"
                                                    rows="3" required>{{ old('content') }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="rating-{{ $product->id }}">Rating:</label><br>
                                                <div id="star-rating-{{ $product->id }}">
                                                    <span class="star" data-rating="1" onclick="setRating('{{ $product->id }}', 1)">☆</span>
                                                    <span class="star" data-rating="2" onclick="setRating('{{ $product->id }}', 2)">☆</span>
                                                    <span class="star" data-rating="3" onclick="setRating('{{ $product->id }}', 3)">☆</span>
                                                    <span class="star" data-rating="4" onclick="setRating('{{ $product->id }}', 4)">☆</span>
                                                    <span class="star" data-rating="5" onclick="setRating('{{ $product->id }}', 5)">☆</span>
                                                    <input type="hidden" name="rating" id="rating-value-{{ $product->id }}" value="">
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Kirim Testimoni</button>
                                        </form>
                                    @endif
                                @else
                                    <p>Anda harus membeli produk ini terlebih dahulu untuk memberikan testimoni.</p>
                                @endif
                            @else
                                <p>Silakan melakukan <a href="{{ route('login') }}">pemesanan</a> untuk memberikan
                                    testimoni.</p>
                                    @endauth

                                    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar
                                        Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Pemesanan (Order) -->
                <div class="modal fade" id="shippingOptionsModal{{ $product->id }}" tabindex="-1"
                    aria-labelledby="shippingOptionsModalLabel{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="shippingOptionsModalLabel{{ $product->id }}">Pilih Metode Pengiriman
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @auth
                                    <form action="{{ route('orders.store') }}" method="POST" id="shippingForm{{ $product->id }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="from_product_page" value="1">

                                        @php
                                            $user = Auth::user();
                                            $wilayahDesa = $user->wilayahDesa;
                                        @endphp

                                        <input type="hidden" name="shipping_method" id="shipping_method{{ $product->id }}"
                                            value="{{ ($wilayahDesa && $wilayahDesa->tersedia_delivery) ? 'delivery' : 'self_pickup' }}">

                                        <div class="mb-3">
                                            <label class="form-label">Metode Pengiriman</label>
                                            @if ($wilayahDesa)
                                                @if ($wilayahDesa->tersedia_delivery)
                                                    <div class="form-check">
                                                        <input class="form-check-input shipping-option" type="radio" name="shipping_option"
                                                            id="delivery{{ $product->id }}" value="delivery" checked
                                                            data-product-id="{{ $product->id }}"
                                                            data-shipping-cost="{{ $wilayahDesa->ongkos_kirim }}">
                                                        <label class="form-check-label" for="delivery{{ $product->id }}">
                                                            Delivery (Rp {{ number_format($wilayahDesa->ongkos_kirim, 0, ',', '.') }})
                                                        </label>
                                                    </div>
                                                @endif
                                                <div class="form-check">
                                                    <input class="form-check-input shipping-option" type="radio" name="shipping_option"
                                                        id="self_pickup{{ $product->id }}" value="self_pickup"
                                                        data-product-id="{{ $product->id }}" data-shipping-cost="0"
                                                        {{ !$wilayahDesa->tersedia_delivery ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="self_pickup{{ $product->id }}">
                                                        Self Pick-up (Gratis)
                                                    </label>
                                                </div>
                                            @else
                                                <p>Wilayah tidak terdaftar. Hanya tersedia Self Pick-up.</p>
                                                <input type="hidden" name="shipping_option" value="self_pickup">
                                            @endif
                                        </div>

                                        <div class="mb-3" id="address_field{{ $product->id }}"
                                            style="{{ ($wilayahDesa && $wilayahDesa->tersedia_delivery) ? 'display:block' : 'display:none' }}">
                                            <label for="shipping_address{{ $product->id }}" class="form-label">Alamat Pengiriman</label>
                                            <textarea class="form-control" id="shipping_address{{ $product->id }}"
                                                name="shipping_address" rows="3"
                                                required>{{ Auth::user()?->shipping_address ?? 'Silakan login untuk mengisi alamat' }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="quantity{{ $product->id }}" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control quantity-input" id="quantity{{ $product->id }}"
                                                name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                                data-product-id="{{ $product->id }}" data-product-price="{{ $product->price }}">
                                        </div>

                                        <!-- Rincian Pesanan -->
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <strong>Harga Produk:</strong> Rp <span
                                                            id="product_price{{ $product->id }}">{{ number_format($product->price, 0, ',', '.') }}</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Jumlah:</strong> <span id="quantity_display{{ $product->id }}">1</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Biaya Pengiriman:</strong> Rp <span
                                                            id="shipping_cost{{ $product->id }}">0</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Total:</strong> Rp <span id="total_amount{{ $product->id }}">
                                                            {{ number_format($product->price, 0, ',', '.') }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <br>

                                        <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                                    </form>
                                @else
                                    <p>Silakan <a href="{{ route('login') }}">login</a> untuk melakukan pemesanan.</p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
    </section>
@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
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

            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });

            function toggleAddressField(productId) {
                var addressField = document.getElementById('address_field' + productId);

                if (addressField) {
                    if (document.getElementById('delivery' + productId).checked) {
                        addressField.style.display = 'block';
                    } else {
                        addressField.style.display = 'none';
                    }
                }
            }

            function updateOrderDetails(productId) {
                const quantity = parseInt(document.getElementById('quantity' + productId).value);
                const productPrice = parseFloat(document.getElementById('quantity' + productId).dataset.productPrice);
                const shippingOption = document.querySelector('input[name="shipping_option"]:checked');
                const shippingCost = shippingOption ? parseFloat(shippingOption.dataset.shippingCost) : 0;

                const productPriceDisplay = document.getElementById('product_price' + productId);
                const quantityDisplay = document.getElementById('quantity_display' + productId);
                const shippingCostDisplay = document.getElementById('shipping_cost' + productId);
                const totalAmountDisplay = document.getElementById('total_amount' + productId);

                const subtotal = productPrice * quantity;
                const total = subtotal + shippingCost;

                productPriceDisplay.textContent = productPrice.toLocaleString('id-ID');
                quantityDisplay.textContent = quantity;
                shippingCostDisplay.textContent = shippingCost.toLocaleString('id-ID');
                totalAmountDisplay.textContent = total.toLocaleString('id-ID');
            }

            // Event listener untuk perubahan radio button metode pengiriman
            document.querySelectorAll('.shipping-option').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const productId = this.dataset.productId;
                    document.getElementById('shipping_method' + productId).value = this.value;
                    toggleAddressField(productId);
                    updateOrderDetails(productId); // Perbarui rincian pesanan saat metode pengiriman berubah
                });
            });

            // Event listener untuk perubahan input jumlah
            document.querySelectorAll('.quantity-input').forEach(function(input) {
                input.addEventListener('change', function() {
                    const productId = this.dataset.productId;
                    updateOrderDetails(productId); // Perbarui rincian pesanan saat jumlah berubah
                });
            });

            document.addEventListener('shown.bs.modal', function(event) {
                const modalId = event.target.id;
                if (modalId.startsWith('shippingOptionsModal')) {
                    const productId = modalId.replace('shippingOptionsModal', '');
                    toggleAddressField(productId);
                    updateOrderDetails(productId); // Perbarui rincian pesanan saat modal ditampilkan
                }
            });

            function updateShippingMethod(method, productId) {
                document.getElementById('shipping_method' + productId).value = method;
                var addressField = document.getElementById('address_field' + productId);
                var shippingAddressTextarea = document.getElementById('shipping_address' + productId);

                if (method === 'self_pickup') {
                    addressField.style.display = 'none';
                    shippingAddressTextarea.value = '';
                } else {
                    addressField.style.display = 'block';
                }
            }

            function setRating(productId, rating) {
                // Reset semua bintang menjadi bintang kosong
                const stars = document.querySelectorAll(`#star-rating-${productId} .star`);
                stars.forEach(star => star.textContent = '☆');

                // Isi bintang sesuai dengan rating yang dipilih
                for (let i = 0; i < rating; i++) {
                    stars[i].textContent = '★'; // Atau gunakan ⭐ jika mau
                }

                // Set nilai rating ke input hidden
                document.getElementById(`rating-value-${productId}`).value = rating;
            }

            // Data untuk Chart
            const ratings = @json($product->testimonials()->where('status', 'approved')->pluck('rating'));
            const ratingCounts = {};
            for (let i = 1; i <= 5; i++) {
                ratingCounts[i] = ratings.filter(rating => rating === i).length;
            }

            const labels = Object.keys(ratingCounts);
            const data = Object.values(ratingCounts);

            // Membuat Chart
            const ctx = document.getElementById('ratingChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Rating',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1]'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
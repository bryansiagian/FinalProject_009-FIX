<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#shippingOptionsModal{{ $product->id }}">
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

                        @php
                            // Dapatkan testimoni terkait produk ini, dengan eager load relasi 'user'
                            $testimonials = $product->testimonials()->with('user')->get();
                        @endphp

                        @if ($testimonials->isNotEmpty())
                            @foreach ($testimonials as $testimoni)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="card-title">{{ $testimoni->user->name }}</h5> <!-- Tampilkan nama user -->

                                            @auth
                                                @if(auth()->id() == $testimoni->user_id)
                                                    <!-- Hanya tampilkan dropdown jika ini testimoni user yang login -->
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton{{ $testimoni->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i> <!-- Ikon titik tiga (Font Awesome) -->
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $testimoni->id }}">
                                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editTestimonialModal" data-testimonial="{{ json_encode($testimoni) }}">Edit</a></li>
                                                            <li>
                                                                <form id="delete-testimonial-form-{{ $testimoni->id }}" action="{{ route('testimonial.destroy', $testimoni->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item">Hapus</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                        <p class="card-text">{{ $testimoni->content }}</p>
                                        @if ($testimoni->rating)
                                            <p class="card-text">Rating: {{ $testimoni->rating }} / 5</p>
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

                            @if($hasPurchased)
                                @if(!$testimonial)
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
                                            <textarea class="form-control" id="content-{{ $product->id }}" name="content" rows="3" required>{{ old('content') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="rating-{{ $product->id }}">Rating (opsional):</label>
                                            <select class="form-control" id="rating-{{ $product->id }}" name="rating">
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
                                @endif
                            @else
                                <p>Anda harus membeli produk ini terlebih dahulu untuk memberikan testimoni.</p>
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

    <!-- Modal Pemesanan (Order) -->
    <div class="modal fade" id="shippingOptionsModal{{ $product->id }}" tabindex="-1" aria-labelledby="shippingOptionsModalLabel{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shippingOptionsModalLabel{{ $product->id }}">Pilih Metode Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @auth
                        <form action="{{ route('orders.store') }}" method="POST" id="shippingForm{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="from_product_page" value="1">
                            <input type="hidden" name="shipping_method" id="shipping_method{{ $product->id }}" value="{{ $kodePosData ? 'delivery' : 'self_pickup' }}">

                            <div class="mb-3">
                                <label class="form-label">Metode Pengiriman</label>
                                @if($kodePosData)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="shipping_option" id="delivery{{ $product->id }}" value="delivery" checked onchange="updateShippingMethod('delivery', '{{ $product->id }}')">
                                        <label class="form-check-label" for="delivery{{ $product->id }}">
                                            Delivery (Rp {{ number_format($kodePosData->ongkos_kirim, 0, ',', '.') }})
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="shipping_option" id="self_pickup{{ $product->id }}" value="self_pickup" onchange="updateShippingMethod('self_pickup', '{{ $product->id }}')">
                                        <label class="form-check-label" for="self_pickup{{ $product->id }}">
                                            Self Pick-up (Gratis)
                                        </label>
                                    </div>
                                @else
                                    <p>Kode pos tidak terdaftar. Hanya tersedia Self Pick-up.</p>
                                    <input type="hidden" name="shipping_option" value="self_pickup">
                                @endif
                            </div>

                            <div class="mb-3" id="address_field{{ $product->id }}" style="{{ $kodePosData ? 'display:block' : 'display:none' }}">
                                <label for="shipping_address{{ $product->id }}" class="form-label">Alamat Pengiriman</label>
                                <textarea class="form-control" id="shipping_address{{ $product->id }}" name="shipping_address" rows="3" required>{{ Auth::user()?->shipping_address ?? 'Silakan login untuk mengisi alamat' }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="quantity{{ $product->id }}" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity{{ $product->id }}" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                        </form>
                    @else
                        <p>Silakan <a href="{{ route('login') }}">login</a> untuk melakukan pemesanan.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Testimoni -->
    <div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-labelledby="editTestimonialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTestimonialModalLabel">Edit Testimoni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTestimonialForm" action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="edit_content">Testimoni:</label>
                            <textarea class="form-control" id="edit_content" name="content" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_rating">Rating (opsional):</label>
                            <select class="form-control" id="edit_rating" name="rating">
                                <option value="">Pilih Rating</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Footer-->
@include('layouts.footer')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

        // Inisialisasi dropdown secara manual (penting!)
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl)
        });

        // Fungsi untuk menampilkan/menyembunyikan field alamat
        function toggleAddressField(productId) {
            var addressField = document.getElementById('address_field' + productId);
            var deliveryRadio = document.getElementById('delivery' + productId);

            if (addressField) {
            if (deliveryRadio.checked) {
                addressField.style.display = 'block';
            } else {
                addressField.style.display = 'none';
            }
        }
        }

        // Fungsi untuk validasi form
        function validateForm(productId) {
            var deliveryRadio = document.getElementById('delivery' + productId);
            var shippingAddress = document.getElementById('shipping_address' + productId).value;

            if (deliveryRadio.checked && shippingAddress.trim() === '') {
                alert('Alamat pengiriman harus diisi jika memilih metode pengiriman Delivery.');
                return false; // Mencegah form untuk di-submit
            }

            return true; // Izinkan form untuk di-submit
        }

                function updateShippingMethod(method, productId) {
                    document.getElementById('shipping_method' + productId).value = method;
                }

        // Event listener untuk modal yang ditampilkan
        document.addEventListener('shown.bs.modal', function (event) {
            const modalId = event.target.id;
            if (modalId.startsWith('shippingOptionsModal')) {
                const productId = modalId.replace('shippingOptionsModal', '');
                toggleAddressField(productId);
            }
        });

        // Event listeners untuk radio buttons
        document.querySelectorAll('input[name="shipping_option"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const productId = this.id.replace('delivery', '').replace('self_pickup', '');
                 updateShippingMethod(this.value, productId);
                toggleAddressField(productId);
            });
        });
    });

    function updateShippingMethod(method, productId) {
        document.getElementById('shipping_method' + productId).value = method;
        var addressField = document.getElementById('address_field' + productId);
        var shippingAddressTextarea = document.getElementById('shipping_address' + productId);

        if (method === 'self_pickup') {
            addressField.style.display = 'none';
            shippingAddressTextarea.value = ''; // Kosongkan field alamat
        } else {
            addressField.style.display = 'block';
        }
    }

    // JavaScript untuk Modal Edit Testimoni
    $('#editTestimonialModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var testimonial = button.data('testimonial'); // Extract info from data-* attributes
        console.log(testimonial);
        var modal = $(this);

        modal.find('#edit_content').val(testimonial.content);
        modal.find('#edit_rating').val(testimonial.rating);

        // Set action form ke route yang benar
        var url = '{{ route("testimonial.update", ":id") }}';
        url = url.replace(':id', testimonial.id);
        modal.find('#editTestimonialForm').attr('action', url);
    });
</script>

</body>
</html>
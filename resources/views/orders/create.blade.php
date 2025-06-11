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

<!-- Checkout Section -->
<section class="page-section" id="checkout">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Checkout</h2>
            <h3 class="section-subheading text-muted">Periksa detail pesanan Anda dan selesaikan proses checkout.</h3>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card checkout-card">
                    <div class="card-header">Checkout</div>  <!-- Judul card yang lebih umum -->

                    <div class="card-body">
                        <div class="row"> <!-- Gunakan row di dalam card-body -->
                            <div class="col-md-6"> <!-- Informasi Pengiriman: Lebar 6 kolom -->
                                <h5>Informasi Pengiriman</h5>
                                <form action="{{ route('orders.store') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Metode Pengiriman</label>
                                        @foreach($shippingMethods as $method => $details)
                                            @if($details['tersedia']) <!-- Hanya tampilkan jika tersedia -->
                                                <div class="form-check">
                                                    <input class="form-check-input @error('shipping_method') is-invalid @enderror"
                                                           type="radio" name="shipping_method"
                                                           id="shipping_method_{{ $method }}" value="{{ $method }}"
                                                        {{ old('shipping_method') == $method ? 'checked' : '' }}
                                                        @if($method == 'self_pickup' && !$shippingMethods['delivery']['tersedia']) checked @endif
                                                        onclick="toggleAddressField('{{ $method }}')">

                                                    <label class="form-check-label" for="shipping_method_{{ $method }}">
                                                        {{ $details['name'] }} (Rp {{ number_format($details['cost'], 0, ',', '.') }})
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                        @error('shipping_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3" id="address_field"
                                        style="{{ (old('shipping_method') == 'delivery' && $shippingMethods['delivery']['tersedia']) ? '' : 'display: none;' }}">
                                        <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                                        <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                                  id="shipping_address" name="shipping_address" rows="3"
                                                  @if(!$shippingMethods['delivery']['tersedia']) disabled
                                                  @endif>{{ old('shipping_address', Auth::user()->shipping_address) }}</textarea>
                                        @error('shipping_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                                </form>
                            </div>

                            <div class="col-md-6"> <!-- Rincian Pesanan: Lebar 6 kolom -->
                                <h5>Rincian Pesanan</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach($cartItems as $item)
                                        <li class="list-group-item">
                                            {{ $item->product->name }} x {{ $item->quantity }} - Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </li>
                                    @endforeach
                                    <li class="list-group-item">
                                        <strong>Subtotal:</strong> Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </li>
                                    <li class="list-group-item" id="shipping_cost_display" style="display:none;">
                                        <strong>Biaya Pengiriman:</strong> Rp <span id="shipping_cost_value">0</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Total:</strong> Rp <span id="total_amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- Akhir row -->
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
    function toggleAddressField(method) {
        var addressField = document.getElementById('address_field');
        var shippingAddressTextarea = document.getElementById('shipping_address');
        var shippingCostDisplay = document.getElementById('shipping_cost_display');
        var shippingCostValue = document.getElementById('shipping_cost_value');
        var totalAmountDisplay = document.getElementById('total_amount');

        // Ambil subtotal dari PHP
        var subtotal = {{ $subtotal }}; // Penting: Menggunakan data dari controller

        if (method === 'delivery') {
            addressField.style.display = 'block';
            shippingAddressTextarea.disabled = false;
            shippingCostDisplay.style.display = 'block';

            // Ambil biaya pengiriman dari data shippingMethods (pastikan ini konsisten dengan controller)
            var shippingCost = {{ isset($shippingMethods['delivery']['cost']) ? $shippingMethods['delivery']['cost'] : 0 }};

            shippingCostValue.textContent = shippingCost.toLocaleString('id-ID'); // Format angka
            var totalAmount = subtotal + shippingCost;
            totalAmountDisplay.textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');

        } else {
            addressField.style.display = 'none';
            shippingAddressTextarea.disabled = true;
            shippingCostDisplay.style.display = 'none';

            totalAmountDisplay.textContent = 'Rp ' + subtotal.toLocaleString('id-ID'); // Kembalikan ke subtotal
        }
    }

    // Panggil fungsi saat halaman dimuat untuk menangani nilai 'old'
    document.addEventListener('DOMContentLoaded', function() {
        var selectedMethod = document.querySelector('input[name="shipping_method"]:checked');
        if (selectedMethod) {
            toggleAddressField(selectedMethod.value);
        } else {
            // Jika tidak ada yang dipilih, default ke self pickup dan sembunyikan alamat
            toggleAddressField('self_pickup'); // Pastikan ini sesuai dengan default Anda
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const sectionId = 'checkout';
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
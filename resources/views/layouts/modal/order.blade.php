<!-- Modal Pilihan Pengiriman -->
<div class="modal fade" id="shippingOptionsModal{{ $product->id }}" tabindex="-1" aria-labelledby="shippingOptionsModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shippingOptionsModalLabel{{ $product->id }}">Pilih Metode Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('orders.store') }}" method="POST" id="shippingForm{{ $product->id }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="from_product_page" value="1">

                    <div class="mb-3">
                        <label class="form-label">Metode Pengiriman</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_method" id="delivery{{ $product->id }}" value="delivery" checked onclick="toggleAddressField('{{ $product->id }}')">
                            <label class="form-check-label" for="delivery{{ $product->id }}">
                                Delivery (Rp 10.000)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_method" id="self_pickup{{ $product->id }}" value="self_pickup" onclick="toggleAddressField('{{ $product->id }}')">
                            <label class="form-check-label" for="self_pickup{{ $product->id }}">
                                Self Pick-up (Gratis)
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="address_field{{ $product->id }}">
                        <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                        <textarea class="form-control" id="shipping_address{{ $product->id }}" name="shipping_address" rows="3">{{ Auth::user()?->shipping_address ?? 'Silakan login untuk mengisi alamat' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="quantity{{ $product->id }}" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="quantity{{ $product->id }}" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                    </div>

                    <button type="submit" class="btn btn-primary" onclick="return validateForm('{{ $product->id }}')">Buat Pesanan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAddressField(productId) {
        var addressField = document.getElementById('address_field' + productId);
        var deliveryRadio = document.getElementById('delivery' + productId);

        if (deliveryRadio.checked) {
            addressField.style.display = 'block';
        } else {
            addressField.style.display = 'none';
        }
    }

    function validateForm(productId) {
        var deliveryRadio = document.getElementById('delivery' + productId);
        var shippingAddress = document.getElementById('shipping_address' + productId).value;

        if (deliveryRadio.checked && shippingAddress.trim() === '') {
            alert('Alamat pengiriman harus diisi jika memilih metode pengiriman Delivery.');
            return false; // Mencegah form untuk di-submit
        }

        return true; // Izinkan form untuk di-submit
    }

    // Panggil fungsi saat modal ditampilkan untuk menangani tampilan awal
    document.getElementById('shippingOptionsModal{{ $product->id }}').addEventListener('shown.bs.modal', function () {
        toggleAddressField('{{ $product->id }}');
    });
</script>
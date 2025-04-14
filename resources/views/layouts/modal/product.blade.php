<!-- Modal -->
<div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">  <!-- Tambahkan modal-dialog-centered -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                    </div>
                    <div class="col-md-6">
                        <p>{{ $product->description }}</p>
                        <p>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p>Stock: {{ $product->stock }}</p>
                        <!-- Tambahkan informasi produk lainnya di sini -->

                        @auth
                            <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="quantity">Jumlah:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login untuk Memesan</a>
                        @endauth

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
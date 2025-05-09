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
                    <h4>Berikan Testimoni Anda</h4>
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
                @endauth
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
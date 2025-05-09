<!-- Modal -->
<div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!-- Tambahkan modal-dialog-centered -->
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
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1"
                                        max="{{ $product->stock }}">
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

                    @if ($product->testimonials->isNotEmpty())
                        @foreach ($product->testimonials as $testimoni)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">{{ $testimoni->user->name }}</h5> <!-- Tampilkan nama user -->

                                        @if(auth()->id() == $testimoni->user_id)
                                            <!-- Hanya tampilkan dropdown jika ini testimoni user yang login -->
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton{{ $testimoni->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i> <!-- Ikon titik tiga (Font Awesome) -->
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $testimoni->id }}">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editTestimonialModal">Edit</a></li> <!-- Target ke modal yang sama -->
                                                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('delete-testimonial-form-{{ $testimoni->id }}').submit();">Hapus</a></li>
                                                </ul>
                                                <form id="delete-testimonial-form-{{ $testimoni->id }}" action="{{ route('testimonial.destroy', $testimoni->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        @endif
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
                                    <label for="content">Testimoni:</label>
                                    <textarea class="form-control" id="content" name="content" rows="3" required>{{ old('content') }}</textarea>
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
                        @endif
                    @else
                        <p>Anda harus membeli produk ini terlebih dahulu untuk memberikan testimoni.</p>
                    @endif

                @else
                    <p>Silakan login untuk memberikan testimoni.</p>
                @endauth
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Testimoni (Di luar Loop) -->
<div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-labelledby="editTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTestimonialModalLabel">Edit Testimoni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($testimonial)
                <form action="{{ route('testimonial.update', $testimonial->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="content">Testimoni:</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required>{{ old('content', $testimonial->content) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating (opsional):</label>
                        <select class="form-control" id="rating" name="rating">
                            <option value="">Pilih Rating</option>
                            <option value="1" {{ $testimonial->rating == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $testimonial->rating == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $testimonial->rating == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $testimonial->rating == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $testimonial->rating == 5 ? 'selected' : '' }}>5</option>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Update Testimoni</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
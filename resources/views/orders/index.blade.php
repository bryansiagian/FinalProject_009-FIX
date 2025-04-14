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
<!-- Order History Section-->
<section class="page-section" id="order-history">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Riwayat Pesanan</h2>
            <h3 class="section-subheading text-muted">Lihat daftar pesanan yang pernah Anda buat.</h3>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card order-card">
                    <div class="card-header">Daftar Pesanan</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="thead-light">  <!-- Tambahkan class thead-light untuk header abu-abu -->
                                        <tr class="text-center"> <!-- Tambahkan class text-center untuk memusatkan teks di header -->
                                            <th>Nomor Pesanan</th>
                                            <th>Tanggal Pesanan</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center"> <!-- Membuat tombol berada di tengah -->
                                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm mr-2">Lihat Detail</a>
                                                        <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="order-empty-message">Anda belum memiliki pesanan.</p>
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
</body>
</html>
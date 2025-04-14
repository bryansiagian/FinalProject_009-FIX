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

<!-- Order Detail Section -->
<section class="page-section" id="order-detail">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card order-card">
                    <div class="card-header">Detail Pesanan #{{ $order->id }}</div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="order-info">
                            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at }}</p>
                            <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Metode Pengiriman:</strong> {{ $order->shipping_method }}</p>
                            <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
                        </div>

                        <h3 class="mt-4">Produk yang Dipesan:</h3>

                        <table class="order-items-table">
                            <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->orderItems as $orderItem)
                                <tr>
                                    <td>{{ $orderItem->product->name }}</td>
                                    <td>{{ $orderItem->quantity }}</td>
                                    <td>Rp {{ number_format($orderItem->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($orderItem->quantity * $orderItem->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>

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
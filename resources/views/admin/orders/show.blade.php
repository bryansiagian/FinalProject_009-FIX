<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headDashboard')
    <title>Detail Pesanan</title>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Detail Pesanan #{{ $order->id }}</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Pesanan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <th width="25%">Pelanggan</th>
                                            <td>{{ $order->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pesanan</th>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Metode Pembayaran</th>
                                            <td>{{ $order->payment_method }}</td>
                                        </tr>
                                        <tr>
                                            <th>Metode Pengiriman</th>
                                            <td>{{ $order->shipping_method }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Pengiriman</th>
                                            <td>{{ $order->shipping_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{ $order->status }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="m-0 font-weight-bold text-primary mt-3">Item Pesanan</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('admin.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL::asset('Admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ URL::asset('Admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ URL::asset('Admin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
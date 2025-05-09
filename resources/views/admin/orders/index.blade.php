<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headDashboard')

    <style>
        .btn-action {
          width: 80px; /* Sesuaikan dengan lebar yang diinginkan */
          text-align: center; /* Agar teks berada di tengah tombol */
        }
    </style>
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

                        <!-- Content Row -->
                    <div class="row">

                        <!-- DataTales Example -->
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan</h6>
                                </div>
                                <div class="card-body">

                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Filter Form -->
                                    <form action="{{ route('admin.orders.index') }}" method="GET">
                                        <div class="form-row align-items-center mb-3">
                                            <div class="col-auto">
                                                <label class="mr-2">Status:</label>
                                            </div>
                                            <div class="col-auto">
                                                <select class="form-control" name="status">
                                                    <option value="">Semua Status</option>
                                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="Dikirim" {{ request('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                </select>
                                            </div>

                                            <div class="col-auto">
                                                <label class="ml-2 mr-2">Tanggal Pesanan:</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="date" class="form-control" name="tanggal_pesanan" value="{{ request('tanggal_pesanan') }}">
                                            </div>

                                            <div class="col-auto">
                                                <label class="ml-2 mr-2">Pelanggan:</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="text" class="form-control" name="pelanggan" placeholder="Cari nama pelanggan" value="{{ request('pelanggan') }}">
                                            </div>

                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Filter Form -->

                                    <!-- Total Harga Alert -->
                                    <div class="alert alert-primary alert-heading d-flex align-items-center" role="alert">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <div>
                                            Total Nilai Pesanan: <strong>Rp {{ number_format($totalHargaSeluruhPesanan, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                    <!-- End Total Harga Alert -->

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nomor Pesanan</th>
                                                    <th>Pelanggan</th>
                                                    <th>Tanggal Pesanan</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->user->name }}</td>
                                                        <td>{{ $order->created_at }}</td>
                                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                                        <td>{{ $order->status }}</td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary btn-action mr-1">
                                                                    <i class="fas fa-eye mr-2"></i>Lihat
                                                                </a>
                                                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning btn-action mr-1">
                                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                                </a>
                                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{ $orders->links() }} <!-- Tampilkan link paginasi -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL::asset('Admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ URL::asset('Admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ URL::asset('Admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ URL::asset('Admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ URL::asset('Admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ URL::asset('Admin/js/demo/chart-pie-demo.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ URL::asset('Admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/js/demo/datatables-demo.js')}}"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headDashboard')
    <title>Edit Pesanan</title>
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
                    <h1 class="h3 mb-2 text-gray-800">Edit Pesanan #{{ $order->id }}</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Edit Status Pesanan</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
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
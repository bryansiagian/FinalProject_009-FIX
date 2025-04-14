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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Hi Admin:)</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                        </a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Informasi Tentang Kami</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('Success') }}
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

                                    <form action="{{ route('admin.tentang-kami.update', $tentang_kami->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="nama_toko" class="form-label">Nama Toko</label>
                                            <input type="text" class="form-control @error('nama_toko') is-invalid @enderror" id="nama_toko" name="nama_toko" value="{{ old('nama_toko', $tentang_kami->nama_toko) }}">
                                            @error('nama_toko')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $tentang_kami->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="sejarah" class="form-label">Sejarah</label>
                                            <textarea class="form-control @error('sejarah') is-invalid @enderror" id="sejarah" name="sejarah" rows="5">{{ old('sejarah', $tentang_kami->sejarah) }}</textarea>
                                            @error('sejarah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $tentang_kami->deskripsi) }}</textarea>
                                            @error('profil_lain')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $tentang_kami->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Aktif</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Simpan
                                        </button>
                                        <a href="{{ route('admin.tentang-kami.index') }}" class="btn btn-secondary ms-2">
                                            <i class="fas fa-arrow-left mr-2"></i>Batal
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

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
    <script src="{{ URL::asset('Admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ URL::asset('Admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ URL::asset('Admin/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{ URL::asset('Admin/vendor/chart.js/Chart.min.js')}}"></script>
     <!-- Page level custom scripts -->
    <script src="{{ URL::asset('Admin/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{ URL::asset('Admin/js/demo/chart-pie-demo.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{ URL::asset('Admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/js/demo/datatables-demo.js')}}"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headDashboard')

    <title>Tambah Pengumuman</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Tambah Pengumuman</h1>
                        <!--  Tombol Generate Report bisa dihilangkan jika tidak diperlukan -->
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                        </a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pengumuman</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> Ada kesalahan dalam input Anda.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul:</label>
                                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                                            @error('judul')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="isi" class="form-label">Isi:</label>
                                            <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi" rows="5" required>{{ old('isi') }}</textarea>
                                            @error('isi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="gambar" class="form-label">File Gambar</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="gambar" name="gambar" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="gambar">Choose file</label>
                                                </div>
                                            </div>
                                            @error('gambar')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi:</label>
                                            <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi') }}">
                                            @error('tanggal_publikasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Simpan
                                        </button>
                                        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">
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
            @include('admin.footer')
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <script>
        // Tambahkan event listener untuk mengubah teks label saat file dipilih
        document.querySelector('.custom-file-input').addEventListener('change',function(e){
          var fileName = document.getElementById("gambar").files[0].name;
          var nextSibling = e.target.nextElementSibling
          nextSibling.innerText = fileName
        })
    </script>

</body>

</html>
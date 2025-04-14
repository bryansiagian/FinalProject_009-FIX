<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headDashboard')
    <title>Detail Pengumuman</title>
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
                    <h1 class="h3 mb-2 text-gray-800">Detail Pengumuman</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Pengumuman</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <th width="25%">Judul</th>
                                            <td>{{ $pengumuman->judul }}</td>
                                        </tr>
                                        <tr>
                                            <th>Isi</th>
                                            <td>{!! $pengumuman->isi !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Gambar</th>
                                            <td>
                                                @if($pengumuman->gambar)
                                                    <img src="{{ asset('storage/pengumuman/' . $pengumuman->gambar) }}" alt="Gambar" style="max-width: 200px;">
                                                @else
                                                    <p>Tidak ada gambar</p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Publikasi</th>
                                            <td>{{ $pengumuman->tanggal_publikasi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Aktif</th>
                                            <td>{{ $pengumuman->aktif ? 'Ya' : 'Tidak' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-primary">Kembali</a>

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


    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL::asset('Admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ URL::asset('Admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ URL::asset('Admin/js/sb-admin-2.min.js')}}"></script>

</body>

</html>
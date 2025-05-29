<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headDashboard')

    <title>Daftar Pengumuman</title>

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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pengumuman</h6>
                        </div>
                        <div class="card-body">

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif

                            <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus mr-2"></i>Tambah Pengumuman
                            </a>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Judul</th>
                                            <th>Isi</th>
                                            <th>Gambar</th>
                                            <th>Tanggal Publikasi</th>
                                            <th>Tanggal Diedit</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengumumen as $pengumuman)
                                            <tr>
                                                <td>{{ $pengumuman->id }}</td>
                                                <td>{{ $pengumuman->judul }}</td>
                                                <td>{!! Str::limit($pengumuman->isi, 50) !!}</td>
                                                <td>
                                                    @if($pengumuman->gambar)
                                                        <img src="{{ asset('storage/pengumuman/' . $pengumuman->gambar) }}" alt="Gambar" style="max-width: 50px;">
                                                    @else
                                                        Tidak ada gambar
                                                    @endif
                                                </td>
                                                <td>{{ $pengumuman->created_at->format('d M Y H:i') }}</td>
                                                <td>{{ $pengumuman->updated_at->format('d M Y H:i') }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('admin.pengumuman.show', $pengumuman->id) }}" class="btn btn-sm btn-info btn-action mr-1">
                                                            <i class="fas fa-eye mr-2"></i>Lihat
                                                        </a>
                                                        <a class="btn btn-sm btn-warning btn-action mr-1" href="{{ route('admin.pengumuman.edit',$pengumuman->id) }}">
                                                            <i class="fas fa-edit mr-2"></i>Edit
                                                        </a>
                                                         <!-- Tombol Hapus dengan Modal -->
                                                        <button type="button" class="btn btn-sm btn-danger btn-action delete-button" data-toggle="modal" data-target="#deleteModal" data-pengumuman-id="{{ $pengumuman->id }}">
                                                            <i class="fas fa-trash-alt mr-2"></i>Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

    <!-- Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin menghapus pengumuman ini?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-danger" id="confirmDeleteButton">Hapus</a>
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
    <script src="{{ URL::asset('Admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/js/demo/datatables-demo.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.delete-button').click(function() {
                var pengumumanId = $(this).data('pengumuman-id');
                var deleteUrl = "{{ route('admin.pengumuman.destroy', '') }}/" + pengumumanId;
                $('#confirmDeleteButton').attr('href', deleteUrl);
            });
        });
    </script>

</body>

</html>
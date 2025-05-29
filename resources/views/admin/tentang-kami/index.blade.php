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
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Informasi Tentang Kami</h6>
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

                                    <a href="{{ route('admin.tentang-kami.create') }}" class="btn btn-primary mb-3">
                                        <i class="fas fa-plus mr-2"></i> Tambah Baru
                                    </a>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nama Toko</th>
                                                    <th>Alamat</th>
                                                    <th>Sejarah</th>
                                                    <th>Deskripsi</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tentang_kami as $tentangKami)
                                                    <tr>
                                                        <td>{{ $tentangKami->nama_toko }}</td>
                                                        <td>{{ $tentangKami->alamat }}</td>
                                                        <td>{{ $tentangKami->sejarah }}</td>
                                                        <td>{{ $tentangKami->deskripsi }}</td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('admin.tentang-kami.edit', $tentangKami->id) }}" class="btn btn-sm btn-warning btn-action mr-1">
                                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                                </a>
                                                                <!-- Tombol Hapus dengan Modal -->
                                                                <button type="button" class="btn btn-sm btn-danger btn-action delete-button" data-toggle="modal" data-target="#deleteModal" data-tentang-kami-id="{{ $tentangKami->id }}">
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
                <div class="modal-body">Apakah Anda yakin ingin menghapus informasi ini?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
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
    <script src="{{ URL::asset('Admin/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{ URL::asset('Admin/js/demo/chart-pie-demo.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ URL::asset('Admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('Admin/js/demo/datatables-demo.js')}}"></script>

     <script>
        $(document).ready(function() {
            $('.delete-button').click(function() {
                var tentangKamiId = $(this).data('tentang-kami-id');

                $('#confirmDeleteButton').off('click').on('click', function() {
                    // Buat form DELETE secara dinamis
                    var form = $('<form>', {
                        'action': "{{ route('admin.tentang-kami.destroy', ['tentang_kami' => ':id']) }}".replace(':id', tentangKamiId),
                        'method': 'POST',
                        'style': 'display:none' // Sembunyikan form
                    }).append($('<input>', {
                        'name': '_method',
                        'value': 'DELETE',
                        'type': 'hidden'
                    })).append($('<input>', {
                        'name': '_token',
                        'value': "{{ csrf_token() }}", // Tambahkan CSRF token
                        'type': 'hidden'
                    }));

                    // Tambahkan form ke body dan submit
                    $('body').append(form);
                    form.submit();
                });
            });
        });
    </script>
</body>

</html>
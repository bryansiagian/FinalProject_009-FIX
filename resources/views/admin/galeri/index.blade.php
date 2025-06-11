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
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Gambar di Galeri</h6>
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

                                    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary mb-3">
                                        <i class="fas fa-plus mr-2"></i> Tambah Gambar Baru
                                    </a>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nama Gambar</th>
                                                    <th>Gambar</th>
                                                    <th>Deskripsi</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($galeri as $item)
                                                    <tr>
                                                        <td>{{ $item->nama_gambar }}</td>
                                                        <td>
                                                            <img src="{{ asset('storage/' . $item->path) }}" alt="{{ $item->nama_gambar }}" style="max-width: 100px;">
                                                        </td>
                                                        <td>{{ $item->deskripsi }}</td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-sm btn-warning btn-action mr-1">
                                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                                </a>
                                                                <!-- Tombol Hapus dengan Modal -->
                                                                <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-sm btn-danger btn-action delete-button" data-toggle="modal" data-target="#deleteModal" data-galeri-id="{{ $item->id }}">
                                                                        <i class="fas fa-trash-alt mr-2"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4">Tidak ada gambar di galeri.</td>
                                                    </tr>
                                                @endforelse
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
                <div class="modal-body">Apakah Anda yakin ingin menghapus gambar ini?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" id="confirmDeleteButton" type="button">Hapus</button>
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

    <script>
        $(document).ready(function() {
            $("#dataTable").DataTable({
                ordering: false, // Sesuaikan dengan kebutuhan Anda
                initComplete: function() {
                    // Delegated Event Handler untuk Tombol Delete
                    $(document).on('click', '.delete-button', function(e) {
                        e.preventDefault(); // Prevent default button behavior
                        var galeriId = $(this).data('galeri-id');
                        $('#confirmDeleteButton').data('galeri-id', galeriId); // Simpan galeriId di tombol confirm
                    });

                    // Handler untuk Tombol Konfirmasi di Modal
                    $('#confirmDeleteButton').click(function() {
                        var galeriId = $(this).data('galeri-id');
                        // Cari form yang sesuai dan submit
                        $('form[action="' + '{{ route('admin.galeri.destroy', '') }}/' + galeriId + '"]').submit();
                    });
                },
                language: {
                    "emptyTable": "Tidak ada gambar di galeri."
                }
            });
        });
    </script>
</body>

</html>
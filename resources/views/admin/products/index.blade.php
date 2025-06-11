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
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
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

                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i> Tambah Produk
                                    </a>
                                    <br><br>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Deskripsi</th>
                                                    <th>Gambar</th>
                                                    <th>Harga</th>
                                                    <th>Stok</th>
                                                    <th>Kategori</th> <!-- Kolom Kategori -->
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{!! Str::limit(nl2br($item->description), 100) !!}</td>
                                                        <td>
                                                            @if($item->image)
                                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar Produk" style="max-width: 100px;">
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                                        <td>{{ $item->stock }}</td>
                                                        <td>{{ $item->category }}</td> <!-- Tampilkan Kategori -->
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">
                                                                <a href="{{ route('admin.products.edit', ['products' => $item->id]) }}" class="btn btn-sm btn-warning btn-action mr-1">
                                                                    <i class="fas fa-edit mr-2"></i>Edit
                                                                </a>
                                                                <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-sm btn-danger btn-action delete-button" data-toggle="modal" data-target="#deleteModal" data-product-id="{{ $item->id }}">
                                                                        <i class="fas fa-trash-alt mr-2"></i>Delete
                                                                    </button>
                                                                </form>
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
                <div class="modal-body">Apakah Anda yakin ingin menghapus produk ini?</div>
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
            // 1. Inisialisasi DataTables
            $("#dataTable").DataTable({
                ordering: false, // Menonaktifkan pengurutan
                // 2. Setelah DataTables diinisialisasi, ikat delegated event handler
                initComplete: function() {
                    // 3. Delegated Event Handler untuk Tombol Delete
                    $(document).on('click', '.delete-button', function(e) {
                        e.preventDefault(); // Prevent default button behavior
                        var productId = $(this).data('product-id');
                        $('#confirmDeleteButton').data('product-id', productId); // Simpan productId di tombol confirm
                    });

                    // 4. Handler untuk Tombol Konfirmasi di Modal
                    $('#confirmDeleteButton').click(function() {
                        var productId = $(this).data('product-id');
                        // Cari form yang sesuai dan submit
                        $('form[action="' + '{{ route('admin.products.destroy', '') }}/' + productId + '"]').submit();
                    });
                }
            });
        });
    </script>
</body>
</html>
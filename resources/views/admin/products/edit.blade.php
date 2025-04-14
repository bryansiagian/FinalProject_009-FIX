<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headDashboard')
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
                                    <h6 class="m-0 font-weight-bold text-primary">Edit Produk</h6>
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

                                    <form action="{{ route('admin.products.update', $products->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Produk:</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $products->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Deskripsi:</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="5" required>{{ old('description', $products->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">Gambar</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @if($products->image)
                                                <img src="{{ asset('storage/' . $products->image) }}" alt="Gambar Produk" style="max-width: 300px; margin-top: 10px;">
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label for="price" class="form-label">Harga:</label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price', $products->price) }}" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stok:</label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" value="{{ old('stock', $products->stock) }}" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>Simpan
                                        </button>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Kembali
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
                    <h5 class="modal-title" id="exampleModalLabel">Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Klik "Logout" untuk keluar dari halaman admin. Sampai jumpa admin : )
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Cancel
                    </button>
                    <a class="btn btn-primary" href="{{ route('welcome')}}">Logout</a>
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
          var fileName = document.getElementById("image").files[0].name;
          var nextSibling = e.target.nextElementSibling
          nextSibling.innerText = fileName
        })
    </script>
</body>
</html>

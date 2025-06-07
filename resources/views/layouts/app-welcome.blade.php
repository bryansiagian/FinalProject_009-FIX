<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <title>@yield('title', 'HARMONIS PLASTIK')</title>
</head>

<body id="page-top">
    <!-- Navigation-->
    @include('layouts.navbar-welcome')

    <!-- Alert -->
    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Masthead-->
    @include('layouts.header')

    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('admin.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    @yield('scripts')
</body>
</html>
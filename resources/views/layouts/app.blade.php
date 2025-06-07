<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <title>@yield('title', 'HARMONIS PLASTIK')</title>
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')

<div class="content">
    @yield('content')
</div>

<!-- Footer-->
@include('layouts.footer')

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts.js') }}"></script>
<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
@yield('scripts')
</body>
</html>
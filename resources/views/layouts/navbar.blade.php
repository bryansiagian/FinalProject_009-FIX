<nav class="navbar navbar-expand-md navbar-dark fixed-top" id="mainNav">
    <div class="container">
        {{-- Asumsi route untuk home page bernama 'welcome' atau 'home' --}}
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" height="80"/>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                {{-- Tambahkan kelas 'active' jika route saat ini adalah 'welcome' --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}" href="{{ route('welcome') }}">HOME</a>
                </li>
                {{-- Tambahkan kelas 'active' jika route saat ini adalah 'products.index' --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">PRODUK</a>
                </li>
                 {{-- Tambahkan kelas 'active' jika route saat ini adalah 'pengumuman.public' --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pengumuman.public') ? 'active' : '' }}" href="{{ route('pengumuman.public') }}">PENGUMUMAN</a>
                </li>
                 {{-- Tambahkan kelas 'active' jika route saat ini adalah 'galeri.public' --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('galeri.public') ? 'active' : '' }}" href="{{ route('galeri.public') }}">GALERI</a>
                </li>
                 {{-- Tambahkan kelas 'active' jika route saat ini adalah 'tentang-kami.public' --}}
                 <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tentang-kami.public') ? 'active' : '' }}" href="{{ route('tentang-kami.public') }}">Tentang Kami</a>
                </li>
                 {{-- Tambahkan kelas 'active' jika route saat ini adalah 'kontak.public' --}}
                 <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kontak.public') ? 'active' : '' }}" href="{{ route('kontak.public') }}">Kontak</a>
                </li>


                {{-- Authentication Links --}}
                @guest
                    @if (Route::has('login'))
                        {{-- Tambahkan kelas 'active' jika route saat ini adalah 'login' --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif
                @else

                    {{-- Riwayat Pesanan --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">Riwayat Pesanan</a>
                    </li>

                    {{-- Keranjang --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index')}}">KERANJANG</a>
                    </li>

                    {{-- Logout --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            Logout
                        </a>
                    </li>

                    {{-- Dashboard Admin --}}
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                            </li>
                        @endif
                    @endauth
                @endguest
            </ul>
        </div>
    </div>
</nav>  {{-- Tutup tag nav --}}

{{-- Modal Logout --}}
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Script Scroll Navbar --}}
<script>
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('#mainNav');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
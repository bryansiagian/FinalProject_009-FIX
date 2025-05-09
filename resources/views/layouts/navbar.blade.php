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

                {{-- Dropdown "Lainnya" - Parent link aktif jika salah satu child aktif --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        {{ request()->routeIs('tentang-kami.public') ||
                           request()->routeIs('kontak.public') ||
                           request()->routeIs('testimonial.index') ? 'active' : '' }}"
                       href="#" id="navbarDropdownMore" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Lainnya
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMore">
                        {{-- Item dropdown juga bisa ditambahkan 'active' jika diperlukan, tapi biasanya cukup parent-nya --}}
                        <li><a class="dropdown-item {{ request()->routeIs('tentang-kami.public') ? 'active' : '' }}" href="{{ route('tentang-kami.public') }}">Tentang Kami</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('kontak.public') ? 'active' : '' }}" href="{{ route('kontak.public') }}">Kontak</a></li>
                        {{-- <li><a class="dropdown-item {{ request()->routeIs('testimonial.index') ? 'active' : '' }}" href="{{ route('testimonial.index') }}">Testimoni</a></li> --}}
                    </ul>
                </li>

                 {{-- Authentication Links --}}
                 @guest
                    @if (Route::has('login'))
                        {{-- Tambahkan kelas 'active' jika route saat ini adalah 'login' --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                         {{-- Tambahkan kelas 'active' jika route saat ini adalah 'register' --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    {{-- User Dropdown - Parent biasanya tidak perlu 'active', tapi item di dalamnya bisa --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            {{-- Tambahkan kelas 'active' jika route saat ini adalah 'orders.index' --}}
                            <a class="dropdown-item {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">Riwayat Pesanan</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                     {{-- Tambahkan kelas 'active' jika route saat ini adalah 'cart.index' --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" href="{{ route('cart.index')}}">KERANJANG</a>
                    </li>

                    {{-- Tambahkan kelas 'active' jika route saat ini adalah 'admin.dashboard' (atau admin.* jika perlu lebih luas) --}}
                    @if(Auth::check() && Auth::user()->is_admin) {{-- Pastikan method is_admin ada atau sesuaikan kondisinya --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                            {{-- Menggunakan 'admin.dashboard*' akan membuatnya aktif jika URL dimulai dengan route 'admin.dashboard', berguna jika ada sub-halaman dashboard --}}
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
</nav>

{{-- Script Scroll Navbar (tidak berubah, tetap di sini) --}}
<script>
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('#mainNav'); // Target ID #mainNav lebih spesifik
        if (window.scrollY > 50) { // Sesuaikan nilai 50 jika perlu
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>

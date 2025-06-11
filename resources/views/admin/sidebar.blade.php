<ul
    class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion"
    id="accordionSidebar"
>
    <!-- Sidebar - Brand -->
    <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route('admin.dashboard') }}"
    >
        <div class="sidebar-brand-icon">
            <i class="fas fa-box"></i> <!-- Contoh icon untuk Harmonis Plastik -->
        </div>
        <div class="sidebar-brand-text mx-3">
            ADMIN <br> HARMONIS PLASTIK</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-chart-line fa-fw"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Interface</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseTwo"
            aria-expanded="true"
            aria-controls="collapseTwo"
        >
            <i class="fas fa-database fa-fw"></i>
            <span>CRUD</span>
        </a>
        <div
            id="collapseTwo"
            class="collapse"
            aria-labelledby="headingTwo"
            data-parent="#accordionSidebar"
        >
            <div class="bg-light py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart fa-fw mr-2"></i>Kelola Pesanan</a>
                <a class="collapse-item" href="{{route('admin.products.index')}}">
                    <i class="fas fa-box mr-2"></i>Produk</a>
                 <!-- Tambahkan link Kode Pos di sini -->
                <a class="collapse-item" href="{{ route('admin.kode_pos.index') }}">
                    <i class="fas fa-map-marker mr-2"></i>Kode Pos</a>
                <a class="collapse-item" href="{{ route('admin.wilayah-desa.index') }}">
                    <i class="fas fa-map-marker mr-2"></i>Wilayah Desa</a>
                <a class="collapse-item" href="{{ route('admin.pengumuman.index') }}">
                    <i class="fas fa-bullhorn mr-2"></i>Pengumuman</a>
                <a class="collapse-item" href="{{ route('admin.galeri.index') }}">
                    <i class="fas fa-images mr-2"></i>Galeri</a>
                <a class="collapse-item" href="{{route('admin.testimonials.index')}}">
                    <i class="fas fa-comment-dots mr-2"></i>Testimoni</a>
                <a class="collapse-item" href="{{ route('admin.tentang-kami.index') }}">
                    <i class="fas fa-file-alt mr-2"></i>Tentang Kami</a>
                <a class="collapse-item" href="{{ route('admin.kontak.index') }}">
                    <i class="fas fa-phone mr-2"></i>Kontak</a>
            </div>
        </div>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
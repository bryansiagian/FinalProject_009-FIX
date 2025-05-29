<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body id="page-top">
<!-- Navigation-->
@include('layouts.navbar')

<!-- Masthead-->
@include('layouts.header')
<!-- Order History Section-->
<section class="page-section" id="order-history" data-aos="fade-up">
    <div class="container">
        <div class="text-center">
            <h2 class="mt-0 section-heading text-uppercase">Riwayat Pesanan</h2>
            <h3 class="section-subheading text-muted">Lihat daftar pesanan yang pernah Anda buat.</h3>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-down" data-aos-delay="100">
                <div class="card order-card">
                    <div class="card-header">Daftar Pesanan</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" data-aos="fade-left" data-aos-delay="200">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger" data-aos="fade-left" data-aos-delay="200">{{ session('error') }}</div>
                        @endif

                        @if($orders->count() > 0)
                            <div class="table-responsive" data-aos="fade-right" data-aos-delay="300">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr class="text-center">
                                            <th>Nomor Pesanan</th>
                                            <th>Tanggal Pesanan</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr data-aos="zoom-in" data-aos-delay="{{ 100 * $loop->index }}">
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center flex-wrap">
                                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm mr-2 mb-1">
                                                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                                                        </a>
                                                        @if($order->status == 'pending')
                                                        <button type="button" class="btn btn-danger btn-sm mb-1"
                                                            onclick="showCancelModal(this)"
                                                            data-id="{{ $order->id }}">
                                                            <i class="fas fa-times mr-1"></i> Batalkan
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="order-empty-message" data-aos="fade-up" data-aos-delay="400">Anda belum memiliki pesanan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi Pembatalan -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="cancelModalLabel">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin membatalkan pesanan ini?
            </div>
            <div class="modal-footer">
                <form id="cancelForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Footer-->
@include('layouts.footer')

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sectionId = 'order-history';
        const navbarHeight = document.querySelector('.navbar').offsetHeight;

        const section = document.getElementById(sectionId);
        if (section) {
            const scrollPosition = section.offsetTop - navbarHeight;

            window.scrollTo({
                top: scrollPosition,
                behavior: 'smooth'
            });
        }
    });
</script>

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 500,
        once: true,
    });
</script>
<script>
    function showCancelModal(button) {
        const form = document.getElementById('cancelForm');
        const orderId = button.getAttribute('data-id');

        // URL dasar langsung ditulis sesuai rute
        const actionUrl = `/orders/${orderId}/cancel`;

        form.action = actionUrl;

        const cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
        cancelModal.show();
    }
</script>


</body>
</html>
<div class="modal fade" id="pengumumanModal{{ $pengumuman->id }}" tabindex="-1" aria-labelledby="pengumumanModalLabel{{ $pengumuman->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Menggunakan modal-lg untuk tampilan yang lebih luas -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengumumanModalLabel{{ $pengumuman->id }}">{{ $pengumuman->judul }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($pengumuman->gambar)
                    <img src="{{ asset('storage/pengumuman/' . $pengumuman->gambar) }}" class="img-fluid mb-3" alt="{{ $pengumuman->judul }}">
                @endif
                {!! $pengumuman->isi !!}
                <p class="card-text tanggal">Tanggal: {{ $pengumuman->tanggal_publikasi->format('Y-m-d') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
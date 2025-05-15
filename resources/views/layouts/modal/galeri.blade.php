<div class="modal fade" id="galeriModal{{ $gambar->id }}" tabindex="-1" aria-labelledby="galeriModalLabel{{ $gambar->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galeriModalLabel{{ $gambar->id }}">{{ $gambar->nama_gambar }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/' . $gambar->path) }}" class="img-fluid mb-3" alt="{{ $gambar->nama_gambar }}">
                <p>{{ $gambar->deskripsi }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-header">
    <h5 class="modal-title" id="filterModalLabel">Filter Data Jawaban Pengguna</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form id="filterForm" method="GET" action="{{ route('jawaban_pengguna.list') }}">
        <div class="mb-3">
            <label for="pertanyaan_id" class="form-label">Pertanyaan</label>
            <select class="form-select" id="pertanyaan_id" name="pertanyaan_id" style="max-width: 100%; overflow-x: auto; white-space: normal;">
                <option value="">Memuat...</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="pengguna" class="form-label">Pengguna</label>
            <input type="text" class="form-control" id="pengguna" name="pengguna" placeholder="Cari nama pengguna...">
        </div>
        <div class="mb-3">
            <label for="alumni" class="form-label">Alumni</label>
            <input type="text" class="form-control" id="alumni" name="alumni" placeholder="Cari nama alumni...">
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" id="resetFilter">Reset</button>
            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
        </div>
    </form>
</div>
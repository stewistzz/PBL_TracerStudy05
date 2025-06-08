<form id="filterForm">
    <div class="mb-3">
        <label for="filter_program_studi" class="form-label">Program Studi</label>
        <select class="form-select" id="filter_program_studi" name="program_studi">
            <option value="">Semua Program Studi</option>
            @foreach (App\Models\AlumniModel::distinct()->pluck('program_studi') as $prodi)
                <option value="{{ $prodi }}">{{ $prodi }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="filter_tahun_lulus_start" class="form-label">Tahun Lulus (Dari)</label>
        <input type="number" class="form-control" id="filter_tahun_lulus_start" name="tahun_lulus_start"
            placeholder="Contoh: 2010">
    </div>
    <div class="mb-3">
        <label for="filter_tahun_lulus_end" class="form-label">Tahun Lulus (Sampai)</label>
        <input type="number" class="form-control" id="filter_tahun_lulus_end" name="tahun_lulus_end"
            placeholder="Contoh: 2025">
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
        <button type="button" class="btn btn-secondary" id="resetFilter">Reset Filter</button>
    </div>
</form>

<script>
    // Submit form filter
    $(document).on('submit', '#filterForm', function(e) {
        e.preventDefault();
        console.log('Filter form submitted'); // Debugging
        let start = $('#filter_tahun_lulus_start').val();
        let end = $('#filter_tahun_lulus_end').val();
        if (start && end && parseInt(start) > parseInt(end)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tahun mulai harus lebih kecil dari tahun akhir!'
            });
            return;
        }
        $('#alumni-table').DataTable().ajax.reload();
        $('#filterModal').modal('hide');
    });

    // Reset filter
    $(document).on('click', '#resetFilter', function() {
        console.log('Reset filter clicked'); // Debugging
        $('#filter_program_studi').val('');
        $('#filter_tahun_lulus_start').val('');
        $('#filter_tahun_lulus_end').val('');
        $('#masa-tunggu-table').DataTable().ajax.reload();
        $('#filterModal').modal('hide');
    });
</script>

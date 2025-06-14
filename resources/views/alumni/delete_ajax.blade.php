{{-- <div class="modal-dialog modal-sm modal-dialog-centered"> --}}
    <div class="modal-content shadow-lg">
        <form id="form-delete" action="{{ route('alumni.delete_ajax', ['id' => $data->alumni_id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="mdi mdi-delete-forever text-danger display-4"></i>
                <p>Yakin ingin menghapus data alumni ini?</p>
                <strong>{{ $data->nama ?? 'Nama tidak tersedia' }}</strong>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Batal</button>
                <button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-check-circle-outline"></i>Ya, Hapus</button>
            </div>
        </form>
    </div>
{{-- </div> --}}

<script>
$('#form-delete').on('submit', function(e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let data = form.serialize();

    console.log('Submitting DELETE to:', url); // Debugging

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {
            if (response.status) {
                $('#modal-form').modal('hide');
                Swal.fire('Dihapus', response.message, 'success');
                $('#alumni-table').DataTable().ajax.reload();
            } else {
                Swal.fire('Gagal', response.message, 'error');
            }
        },
        error: function(xhr) {
            console.error('Delete Error:', xhr); // Debugging
            Swal.fire('Error', 'Terjadi kesalahan saat menghapus data: ' + xhr.statusText, 'error');
        }
    });
});
</script>
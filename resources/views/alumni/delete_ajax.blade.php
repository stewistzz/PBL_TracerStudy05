<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <form id="form-delete" action="{{ route('alumni.delete_ajax', ['id' => $data->alumni_id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus data alumni ini?</p>
                <strong>{{ $data->nama ?? 'Nama tidak tersedia' }}</strong>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

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
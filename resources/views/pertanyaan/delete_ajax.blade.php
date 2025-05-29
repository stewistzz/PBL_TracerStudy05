<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <form id="form-delete" action="{{ url('/pertanyaan/'.$data->pertanyaan_id.'/delete_ajax') }}" method="POST">
            @csrf
            @method('DELETE') <!-- Spoofing agar method menjadi DELETE -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Pertanyaan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus pertanyaan ini?</p>
                <strong>{{ $data->isi_pertanyaan }}</strong>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {
            if (response.status) {
                $('#myModal').modal('hide');
                Swal.fire('Dihapus', response.message, 'success');
                $('#pertanyaan-table').DataTable().ajax.reload();
            } else {
                Swal.fire('Gagal', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
        }
    });
});
</script>

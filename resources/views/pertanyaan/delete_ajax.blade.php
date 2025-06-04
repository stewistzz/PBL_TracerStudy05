<div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content shadow-lg">
        <form id="form-delete" action="{{ url('/pertanyaan/'.$data->pertanyaan_id.'/delete_ajax') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-alert-circle-outline mr-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <i class="mdi mdi-delete-forever text-danger display-4"></i>
                <p class="mt-3 mb-1 font-weight-bold">Yakin ingin menghapus pertanyaan ini?</p>
                <p class="text-muted">"{{ $data->isi_pertanyaan }}"</p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="mdi mdi-check-circle-outline"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                    <i class="mdi mdi-close-circle-outline"></i> Batal
                </button>
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
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
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


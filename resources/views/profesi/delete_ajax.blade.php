<div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content shadow-lg">
        <form id="form-delete" action="{{ url('/profesi/'.$data->profesi_id.'/delete_ajax') }}" method="POST">
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
                <p class="mt-3 mb-1 font-weight-bold">Yakin ingin menghapus profesi ini?</p>
                <p class="text-muted">"{{ $data->nama_profesi }}"</p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                    <i class="mdi mdi-close-circle-outline"></i> Batal
                </button>
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="mdi mdi-check-circle-outline"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

{{-- modified delete --}}
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
                $('#profesi-table').DataTable().ajax.reload();
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

{{-- <script>
    function deleteProfesi(id) {
        $.ajax({
            url: `/profesi/${id}/delete_ajax`,
            type: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    $('#profesi-table').DataTable().ajax.reload(null, false);
                    alert(res.message);
                } else {
                    alert(res.message);
                }
            },
            error: function(xhr) {
                alert("Terjadi kesalahan saat menghapus data.");
            }
        });
    }
</script> --}}

<div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content shadow-lg">
        <form id="form-delete" action="{{ url('/kategori_pertanyaan/' . $data->kode_kategori . '/delete_ajax') }}" method="POST">
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
                <p class="mt-3 mb-2 font-weight-bold">Yakin ingin menghapus kategori ini?</p>
                <ul class="list-unstyled text-muted small">
                    <li><strong>ID:</strong> {{ $data->kode_kategori }}</li>
                    <li><strong>Nama:</strong> {{ $data->nama_kategori }}</li>
                </ul>
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
    $(document).ready(function () {
        $('#form-delete').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        $('#kategori_pertanyaan_table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menghapus data.'
                    });
                }
            });
        });
    });
</script>

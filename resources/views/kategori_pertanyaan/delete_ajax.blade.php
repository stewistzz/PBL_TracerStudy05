<form id="form-delete" action="{{ url('/kategori_pertanyaan/' . $data->kode_kategori . '/delete_ajax') }}" method="POST">
    @csrf
    @method('DELETE') <!-- Spoofing agar method menjadi DELETE -->

    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Hapus Data</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kategori berikut ini?</p>
                <ul>
                    <li><strong>ID:</strong> {{ $data->kode_kategori }}</li>
                    <li><strong>Nama Kategori:</strong> {{ $data->nama_kategori }}</li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</form>


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

<form id="form-edit" action="{{ url('/kategori_pertanyaan/' . $data->kode_kategori . '/update_ajax') }}" method="POST">
    @csrf
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Kategori</label>
                    <input type="text" name="kode_kategori" value="{{ $data->kode_kategori }}" class="form-control">
                    <span class="text-danger error-text" id="error-kode_kategori"></span>
                </div>

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ $data->nama_kategori }}" class="form-control">
                    <span class="text-danger error-text" id="error-nama_kategori"></span>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ $data->deskripsi }}</textarea>
                    <span class="text-danger error-text" id="error-deskripsi"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</form>


<script>
    $('#form-edit').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let url = $(this).attr('action');

        $('.error-text').text('');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire('Sukses', response.message, 'success');
                    $('#kategori_pertanyaan_table').DataTable().ajax.reload();
                } else {
                    $.each(response.msgField, function(key, value) {
                        $('#error-' + key).text(value[0]);
                    });
                }
            },
            error: function() {
                Swal.fire('Gagal', 'Terjadi kesalahan saat update data', 'error');
            }
        });
    });
</script>

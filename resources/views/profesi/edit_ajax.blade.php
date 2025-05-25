<form id="form-edit" action="{{ url('/profesi/'.$data->profesi_id.'/update_ajax') }}" method="POST">
    @csrf

    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Data Profesi</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="nama_profesi">Nama Profesi</label>
                    <input type="text" name="nama_profesi" id="nama_profesi" class="form-control" value="{{ $data->nama_profesi }}">
                    <span class="text-danger error-text" id="error-nama_profesi"></span>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}" {{ $data->kategori_id == $k->kategori_id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text" id="error-kategori_id"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Perbarui</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#form-edit').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                $('.error-text').text('');
            },
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    }).then(() => {
                        $('#profesi-table').DataTable().ajax.reload();
                    });
                } else {
                    $.each(response.msgField, function(prefix, val) {
                        $('#error-' + prefix).text(val[0]);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            }
        });
    });
</script>

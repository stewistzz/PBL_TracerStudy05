<form action="{{ url('/kategori_pertanyaan/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="myModal" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Pertanyaan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Kategori</label>
                    <input type="text" name="kode_kategori" class="form-control" required>
                    <small id="error-kode_kategori" class="text-danger error-text"></small>
                </div>

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
                    <small id="error-nama_kategori" class="text-danger error-text"></small>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    <small id="error-deskripsi" class="text-danger error-text"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#form-tambah').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('.error-text').text('');

        $.ajax({
            url: "{{ url('/kategori_pertanyaan/ajax') }}",
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
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        });
    });
</script>

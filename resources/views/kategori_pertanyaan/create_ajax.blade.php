<form action="{{ url('/kategori_pertanyaan/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-format-list-bulleted-type"></i> Tambah Kategori Pertanyaan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><i class="mdi mdi-code-tags"></i> Kode Kategori</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="mdi mdi-code-braces-box"></i></span>
                        </div>
                        <input type="text" name="kode_kategori" class="form-control" placeholder="Masukkan kode kategori..." required>
                    </div>
                    <small id="error-kode_kategori" class="text-danger error-text"></small>
                </div>

                <div class="form-group">
                    <label><i class="mdi mdi-label-outline"></i> Nama Kategori</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="mdi mdi-tag-multiple-outline"></i></span>
                        </div>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan nama kategori..." required>
                    </div>
                    <small id="error-nama_kategori" class="text-danger error-text"></small>
                </div>

                <div class="form-group">
                    <label><i class="mdi mdi-text"></i> Deskripsi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="mdi mdi-note-text-outline"></i></span>
                        </div>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi kategori..." required></textarea>
                    </div>
                    <small id="error-deskripsi" class="text-danger error-text"></small>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">
                    <i class="mdi mdi-close-circle-outline"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="mdi mdi-content-save-outline"></i> Simpan
                </button>
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

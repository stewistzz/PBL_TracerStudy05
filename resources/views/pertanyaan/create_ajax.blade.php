<form action="{{ url('/pertanyaan/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="mdi mdi-comment-question-outline"></i> Tambah Data Pertanyaan</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><i class="mdi mdi-text"></i> Isi Pertanyaan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="mdi mdi-comment-text-outline"></i></span>
                        </div>
                        <input type="text" name="isi_pertanyaan" class="form-control" placeholder="Masukkan isi pertanyaan..." required>
                    </div>
                    <small class="text-danger error-text" id="error-isi_pertanyaan"></small>
                </div>

                <div class="form-group">
                    <label><i class="mdi mdi-account-switch"></i> Target Role</label>
                    <select name="role_target" class="form-control" required>
                        <option value="">- Pilih Target -</option>
                        <option value="alumni">Alumni</option>
                        <option value="pengguna">Pengguna</option>
                    </select>
                    <small class="text-danger error-text" id="error-role_target"></small>
                </div>

                <div class="form-group">
                    <label><i class="mdi mdi-format-list-bulleted-type"></i> Jenis Pertanyaan</label>
                    <select name="jenis_pertanyaan" class="form-control" required>
                        <option value="">- Pilih Jenis -</option>
                        <option value="isian">Isian</option>
                        <option value="pilihan_ganda">Pilihan Ganda</option>
                        <option value="skala">Skala</option>
                        <option value="ya_tidak">Ya/Tidak</option>
                    </select>
                    <small class="text-danger error-text" id="error-jenis_pertanyaan"></small>
                </div>

                <div class="form-group">
                    <label><i class="mdi mdi-tag-outline"></i> Kategori Pertanyaan</label>
                    <select name="kode_kategori" class="form-control" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->kode_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger error-text" id="error-kode_kategori"></small>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
        url: "{{ url('/pertanyaan/ajax') }}",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            if (res.status) {
                $('#myModal').modal('hide');
                Swal.fire('Berhasil', res.message, 'success');
                $('#pertanyaan-table').DataTable().ajax.reload();
            } else {
                $.each(res.msgField, function(key, value) {
                    $('#error-' + key).text(value[0]);
                });
                Swal.fire('Validasi Gagal', res.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
        }
    });
});
</script>

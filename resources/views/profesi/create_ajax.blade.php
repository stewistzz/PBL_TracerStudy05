<form action="{{ url('/profesi/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="myModal" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Profesi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Profesi</label>
                    <input value="" type="text" name="nama_profesi" id="nama_profesi" class="form-control"
                        required>
                    <small id="error-nama_profesi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kategori Profesi</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">- Pilih kategori -</option>
                        @foreach ($kategori as $l)
                            <option value="{{ $l->kategori_id }}">{{ $l->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
   $(document).ready(function () {
    $('#form-tambah').on('submit', function (e) {
        e.preventDefault(); // Mencegah form submit secara normal

        let form = this;
        let formData = new FormData(form);

        $('.error-text').text(''); // Bersihkan pesan error

        $.ajax({
            url: "{{ url('/profesi/ajax') }}", // langsung hardcoded URL tujuan AJAX
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    });
                    $('#profesi-table').DataTable().ajax.reload();
                } else {
                    $.each(response.msgField, function (key, value) {
                        $('#error-' + key).text(value[0]);
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: response.message
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            }
        });
    });
});

</script>

<form action="{{ url('/profesi/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-account-tie-outline"></i> Tambah Data Profesi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Nama Profesi -->
                <div class="form-group">
                    <label><i class="mdi mdi-briefcase-outline"></i> Nama Profesi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light">
                                <i class="mdi mdi-briefcase"></i>
                            </span>
                        </div>
                        <input type="text" name="nama_profesi" id="nama_profesi" class="form-control" placeholder="Masukkan nama profesi..." required>
                    </div>
                    <small id="error-nama_profesi" class="text-danger error-text"></small>
                </div>

                <!-- Kategori Profesi -->
                <div class="form-group">
                    <label><i class="mdi mdi-tag-outline"></i> Kategori Profesi</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">- Pilih kategori -</option>
                        @foreach ($kategori as $l)
                            <option value="{{ $l->kategori_id }}">{{ $l->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="text-danger error-text"></small>
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

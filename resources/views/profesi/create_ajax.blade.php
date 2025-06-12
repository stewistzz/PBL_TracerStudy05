<!-- resources/views/kategori_profesi/create_ajax.blade.php -->
<form action="{{ url('/profesi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-account-tie-outline"></i> Tambah Data Profesi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
    $('#form-tambah').off('submit').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let data = form.serialize();
        $('.error-text').text('');

        $.ajax({
            url: "{{ url('/profesi/ajax') }}",
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    }).then(() => {
                        $('#profesi-table').DataTable().ajax.reload(null, false);
                    });
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
                console.error('AJAX Error:', xhr);
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
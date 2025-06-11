<!-- resources/views/kategori_profesi/create_ajax.blade.php -->
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title" id="modalLabel">Tambah Kategori</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <input type="hidden" name="id" id="kategori_id">
    <div class="form-group">
        <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
        <div class="invalid-feedback" id="error_nama_kategori"></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
</div>

<script>
$(document).ready(function () {
    $('#form-data').off('submit').on('submit', function (e) {
        e.preventDefault();
        
        // Reset error states
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
        
        // Disable button untuk mencegah double submit
        $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            type: "POST",
            url: "{{ route('kategori_profesi.store') }}",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (res) {
                if (res.status) {
                    $('#modal-form').modal('hide');
                    // Reload tabel di index.blade.php
                    window.loadTable();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (err) {
                if (err.status === 422) {
                    let errors = err.responseJSON.errors;
                    if (errors.nama_kategori) {
                        $('#nama_kategori').addClass('is-invalid');
                        $('#error_nama_kategori').text(errors.nama_kategori[0]).show();
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan sistem!'
                    });
                }
            },
            complete: function() {
                $('#btn-submit').prop('disabled', false).html('Simpan');
            }
        });
    });
});
</script>
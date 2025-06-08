<!-- resources/views/kategori_profesi/edit_ajax.blade.php -->
<div class="modal-header bg-warning text-white">
    <h5 class="modal-title" id="modalLabel">Edit Kategori</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <input type="hidden" name="id" id="kategori_id" value="{{ $kategori->kategori_id }}">
    <div class="form-group">
        <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
        <div class="invalid-feedback" id="error_nama_kategori"></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
    <button type="submit" class="btn btn-warning" id="btn-submit">Update</button>
</div>

<script>
$(document).ready(function () {
    console.log('Edit form loaded'); // Debug: Pastikan script dijalankan
    // Pastikan event submit hanya terikat sekali
    $('#form-data').off('submit').on('submit', function (e) {
        e.preventDefault();
        console.log('Form submitted'); // Debug: Pastikan submit terdeteksi
        
        let id = $('#kategori_id').val();
        let url = "{{ route('kategori_profesi.update', ':id') }}".replace(':id', id);
        
        console.log('URL:', url); // Debug URL
        console.log('Data:', $(this).serialize()); // Debug data
        
        // Reset error states
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
        
        // Disable button untuk mencegah double submit
        $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengupdate...');

        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (res) {
                console.log('Success response:', res); // Debug
                if (res.status) {
                    $('#modal-form').modal('hide');
                    loadTable();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (err) {
                console.log('Error:', err); // Debug
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
                $('#btn-submit').prop('disabled', false).html('Update');
            }
        });
    });
});
</script>
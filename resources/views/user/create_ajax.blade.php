<!-- resources/views/user_profesi/create_ajax.blade.php -->
<div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Tambah User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span>×</span>
    </button>
</div>
<div class="modal-body">
    <input type="hidden" name="id" id="user_id">
    <div class="form-group">
        <label for="username">Username<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="username" id="username" required>
        <div class="invalid-feedback" id="error_username"></div>
    </div>
    <input type="hidden" name="id" id="password">
    <div class="form-group">
        <label for="password">Password<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="password" id="password" required>
        <div class="invalid-feedback" id="error_password"></div>
    </div>
    <div class="form-group">
        <label for="role">Role <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="role" id="role" required>
        <div class="invalid-feedback" id="error_role"></div>
    </div>
</div>


<div class="modal-footer">
    <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
</div>

<script>
    $(document).ready(function() {
        $('#form-data').submit(function(e) {
            e.preventDefault();

            // Reset error states
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('').hide();

            // Disable button untuk mencegah double submit
            $('#btn-submit').prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            $.ajax({
                type: "POST",
                url: "{{ route('user.store') }}",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status) {
                        $('#modal-form').modal('hide');
                        // Reload tabel di index.blade.php
                        loadTable();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
                        if (errors.username) {
                            $('#username').addClass('is-invalid');
                            $('#error_username').text(errors.username[0]).show();
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

<!-- resources/views/kategori_profesi/edit_ajax.blade.php -->
<div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Edit Data User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span>×</span>
    </button>
</div>

<div class="modal-body">
    <input type="hidden" name="id" id="user_id" value="{{ $users->user_id }}">

    <div class="form-group">
        <label for="username">Username <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="username" id="username" value="{{ $users->username }}"
            required>
        <div class="invalid-feedback" id="error_username"></div>
    </div>

    <div class="form-group">
        <label for="password">Password <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="password" id="password" value="{{ $users->password }}"
            disabled>
        <div class="invalid-feedback" id="error_password"></div>
    </div>

    <div class="form-group">
        <label for="role">Role <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="role" id="role" value="{{ $users->role }}"
            disabled>
        <div class="invalid-feedback" id="error_role"></div>
    </div>

</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-success" id="btn-submit">Update</button>
    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
</div>

<script>
    $(document).ready(function() {
        $('#form-data').submit(function(e) {
            e.preventDefault();

            let id = $('#user_id').val();
            let formData = $(this).serialize();

            // Reset error states
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('').hide();

            // Disable tombol submit
            $('#btn-submit').prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin"></i> Mengupdate...');

            $.ajax({
                type: "POST",
                url: "{{ route('user.update', '') }}/" + id,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(res) {
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
                error: function(err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
                        if (errors.username) {
                            $('#username').addClass('is-invalid');
                            $('#error_username').text(errors.username[0]).show();
                        }
                        if (errors.role) {
                            $('#role').addClass('is-invalid');
                            $('#error_role').text(errors.role[0]).show();
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

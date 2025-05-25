<div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Tambah Alumni</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<div class="modal-body">
    <form id="form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="user_id">User <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="error_user_id"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" placeholder="Akan diisi otomatis">
                    <div class="invalid-feedback" id="error_nim"></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama">Nama Alumni</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Akan diisi oleh dosen">
                    <div class="invalid-feedback" id="error_nama"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <div class="invalid-feedback" id="error_email"></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_hp">No HP <span class="text-danger">*</span></label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    <div class="invalid-feedback" id="error_no_hp"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_studi">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" class="form-control" placeholder="Akan diisi oleh dosen">
                    <div class="invalid-feedback" id="error_program_studi"></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="tahun_lulus">Tahun Lulus</label>
            <input type="date" name="tahun_lulus" id="tahun_lulus" class="form-control">
            <small class="text-muted">Akan diisi oleh dosen</small>
            <div class="invalid-feedback" id="error_tahun_lulus"></div>
        </div>
        
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Simpan</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function () {
    console.log('Form create alumni loaded');

    // Mengisi nim otomatis berdasarkan username saat user_id dipilih
    $('#user_id').on('change', function () {
        var selectedUserId = $(this).val();
        if (selectedUserId) {
            var username = $('#user_id option:selected').text();
            $('#nim').val(username);
        } else {
            $('#nim').val('');
        }
    });

    $('#form-data').on('submit', function (e) {
        e.preventDefault();
        console.log('Form submitted');

        // Reset error states
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();

        // Disable button untuk mencegah double submit
        $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "{{ route('alumni.store') }}",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (res) {
                console.log('Success response:', res);
                if (res.status) {
                    $('#modal-form').modal('hide');
                    if (typeof loadTable === 'function') {
                        loadTable();
                    } else {
                        location.reload();
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (err) {
                console.log('Error response:', err);
                if (err.status === 422) {
                    let errors = err.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $('#' + key).addClass('is-invalid');
                        $('#error_' + key).text(errors[key][0]).show();
                    });
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
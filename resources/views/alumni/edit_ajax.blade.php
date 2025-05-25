<div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Edit Alumni</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<div class="modal-body">
    <form id="form-data">
        <input type="hidden" name="alumni_id" id="alumni_id" value="{{ $alumni->alumni_id }}">
        
        <div class="row">
           <div class="col-md-6">
    <div class="form-group">
        <label for="user_id">User <span class="text-danger">*</span></label>
     <input type="text" name="user_id_display" id="user_id_display" class="form-control" value="{{ $alumni->user ? $alumni->user->user_id : 'Tidak ada user terkait' }}" readonly>
        <input type="hidden" name="user_id" value="{{ $alumni->user_id }}">
        <div class="invalid-feedback" id="error_user_id"></div>
    </div>
</div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama">Nama Alumni</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $alumni->nama }}" placeholder="Akan diisi oleh dosen">
                    <div class="invalid-feedback" id="error_nama"></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" value="{{ $alumni->nim }}" placeholder="Akan diisi oleh dosen">
                    <div class="invalid-feedback" id="error_nim"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $alumni->email }}" required>
                    <div class="invalid-feedback" id="error_email"></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_hp">No HP <span class="text-danger">*</span></label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $alumni->no_hp }}" required>
                    <div class="invalid-feedback" id="error_no_hp"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_studi">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" class="form-control" value="{{ $alumni->program_studi }}" placeholder="Akan diisi oleh dosen">
                    <div class="invalid-feedback" id="error_program_studi"></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="tahun_lulus">Tahun Lulus</label>
            <input type="date" name="tahun_lulus" id="tahun_lulus" class="form-control" value="{{ $alumni->tahun_lulus ? $alumni->tahun_lulus->format('Y-m-d') : '' }}">
            <small class="text-muted">Akan diisi oleh dosen</small>
            <div class="invalid-feedback" id="error_tahun_lulus"></div>
        </div>
        
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit">Update</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function () {
    console.log('Form edit alumni loaded');

    $('#form-data').on('submit', function (e) {
        e.preventDefault();
        console.log('Form submitted');

        let id = $('#alumni_id').val();
        console.log('Alumni ID:', id);

        // Reset error states
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();

        // Disable button untuk mencegah double submit
        $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "{{ route('alumni.update', '') }}/" + id,
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
                $('#btn-submit').prop('disabled', false).html('Update');
            }
        });
    });
});
</script>
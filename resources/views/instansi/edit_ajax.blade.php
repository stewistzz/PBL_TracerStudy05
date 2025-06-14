<div class="modal-header bg-warning">
    <h5 class="modal-title" id="modalLabel">Edit Instansi</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<div class="modal-body">
    <form id="form-data">
        <input type="hidden" name="instansi_id" id="instansi_id" value="{{ $instansi->instansi_id }}">

        <div class="form-group">
            <label for="nama_instansi">Nama Instansi <span class="text-danger">*</span></label>
            <input type="text" name="nama_instansi" id="nama_instansi" class="form-control" value="{{ $instansi->nama_instansi }}" required>
            <div class="invalid-feedback" id="error_nama_instansi"></div>
        </div>

        <div class="form-group">
            <label for="jenis_instansi">Jenis Instansi <span class="text-danger">*</span></label>
            <select name="jenis_instansi" id="jenis_instansi" class="form-control" required>
                <option value="Pendidikan Tinggi" {{ $instansi->jenis_instansi == 'Pendidikan Tinggi' ? 'selected' : '' }}>Pendidikan Tinggi</option>
                <option value="Pemerintah" {{ $instansi->jenis_instansi == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                <option value="Swasta" {{ $instansi->jenis_instansi == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                <option value="BUMN" {{ $instansi->jenis_instansi == 'BUMN' ? 'selected' : '' }}>BUMN</option>
            </select>
            <div class="invalid-feedback" id="error_jenis_instansi"></div>
        </div>

        <div class="form-group">
            <label for="skala">Skala <span class="text-danger">*</span></label>
            <select name="skala" id="skala" class="form-control" required>
                <option value="nasional" {{ $instansi->skala == 'nasional' ? 'selected' : '' }}>Nasional</option>
                <option value="internasional" {{ $instansi->skala == 'internasional' ? 'selected' : '' }}>Internasional</option>
                <option value="wirausaha" {{ $instansi->skala == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
            </select>
            <div class="invalid-feedback" id="error_skala"></div>
        </div>

        <div class="form-group">
            <label for="lokasi">Lokasi <span class="text-danger">*</span></label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ $instansi->lokasi }}" required>
            <div class="invalid-feedback" id="error_lokasi"></div>
        </div>

        <div class="form-group">
            <label for="no_hp">No Telepon</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $instansi->no_hp }}">
            <div class="invalid-feedback" id="error_no_hp"></div>
        </div>

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-warning" id="btn-submit">Update</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function () {
    console.log('Form edit loaded');

    $('#form-data').on('submit', function (e) {
        e.preventDefault();
        console.log('Form submitted');

        let id = $('#instansi_id').val();
        console.log('Instansi ID:', id);

        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();

        $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            type: 'POST',
            url: "{{ route('instansi.update', '') }}/" + id,
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

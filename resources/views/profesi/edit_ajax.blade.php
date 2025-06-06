<form id="form-edit" action="{{ url('/profesi/'.$data->profesi_id.'/update_ajax') }}" method="POST">
    @csrf

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="mdi mdi-briefcase-edit-outline"></i> Edit Data Profesi</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                {{-- Nama Profesi --}}
                <div class="form-group">
                    <label for="nama_profesi"><i class="mdi mdi-account-badge-outline"></i> Nama Profesi</label>
                    <input type="text" name="nama_profesi" id="nama_profesi" class="form-control form-control-lg" value="{{ $data->nama_profesi }}" placeholder="Masukkan nama profesi">
                    <small class="text-danger error-text" id="error-nama_profesi"></small>
                </div>

                {{-- Kategori --}}
                <div class="form-group">
                    <label for="kategori_id"><i class="mdi mdi-tag-outline"></i> Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control form-control-lg">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}" {{ $data->kategori_id == $k->kategori_id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-danger error-text" id="error-kategori_id"></small>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="mdi mdi-close-circle-outline"></i> Batal
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="mdi mdi-content-save-outline"></i> Perbarui
                </button>
            </div>
        </div>
    </div>
</form>


<script>
    $('#form-edit').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                $('.error-text').text('');
            },
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    }).then(() => {
                        $('#profesi-table').DataTable().ajax.reload();
                    });
                } else {
                    $.each(response.msgField, function(prefix, val) {
                        $('#error-' + prefix).text(val[0]);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            }
        });
    });
</script>

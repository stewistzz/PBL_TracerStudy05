<form id="form-edit" action="{{ url('/pertanyaan/'.$data->pertanyaan_id.'/update_ajax') }}" method="POST">
    @csrf
    
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Pertanyaan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Isi Pertanyaan</label>
                    <input type="text" name="isi_pertanyaan" class="form-control" value="{{ $data->isi_pertanyaan }}">
                    <span class="text-danger error-text" id="error-isi_pertanyaan"></span>
                </div>

                <div class="form-group">
                    <label>Target Role</label>
                    <select name="role_target" class="form-control">
                        <option value="">- Pilih Target -</option>
                        <option value="alumni" {{ $data->role_target == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        <option value="pengguna" {{ $data->role_target == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                    </select>
                    <span class="text-danger error-text" id="error-role_target"></span>
                </div>

                <div class="form-group">
                    <label>Jenis Pertanyaan</label>
                    <select name="jenis_pertanyaan" class="form-control">
                        <option value="">- Pilih Jenis -</option>
                        <option value="isian" {{ $data->jenis_pertanyaan == 'isian' ? 'selected' : '' }}>Isian</option>
                        <option value="pilihan_ganda" {{ $data->jenis_pertanyaan == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                        <option value="skala" {{ $data->jenis_pertanyaan == 'skala' ? 'selected' : '' }}>Skala</option>
                        <option value="ya_tidak" {{ $data->jenis_pertanyaan == 'ya_tidak' ? 'selected' : '' }}>Ya/Tidak</option>
                    </select>
                    <span class="text-danger error-text" id="error-jenis_pertanyaan"></span>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kode_kategori" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kode_kategori }}" {{ $data->kode_kategori == $k->kode_kategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error-text" id="error-kode_kategori"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Perbarui</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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

    $('.error-text').text('');

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {
            if (response.status) {
                $('#myModal').modal('hide');
                Swal.fire('Berhasil', response.message, 'success');
                $('#pertanyaan-table').DataTable().ajax.reload();
            } else {
                $.each(response.msgField, function(prefix, val) {
                    $('#error-' + prefix).text(val[0]);
                });
                Swal.fire('Gagal', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Terjadi kesalahan saat mengirim data.', 'error');
        }
    });
});
</script>

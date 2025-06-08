<form id="form-edit" action="{{ url('/pertanyaan/' . $data->pertanyaan_id . '/update_ajax') }}" method="POST">
    @csrf

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="mdi mdi-pencil-outline"></i> Edit Pertanyaan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Isi Pertanyaan --}}
                <div class="form-group">
                    <label for="isi_pertanyaan"><i class="mdi mdi-comment-question-outline"></i> Isi Pertanyaan</label>
                    <input type="text" name="isi_pertanyaan" class="form-control form-control-lg"
                        value="{{ $data->isi_pertanyaan }}" placeholder="Masukkan isi pertanyaan">
                    <small class="text-danger error-text" id="error-isi_pertanyaan"></small>
                </div>

                {{-- Target Role --}}
                <div class="form-group">
                    <label for="role_target"><i class="mdi mdi-account-switch"></i> Target Role</label>
                    <select name="role_target" class="form-control form-control-lg">
                        <option value="">- Pilih Target -</option>
                        <option value="alumni" {{ $data->role_target == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        <option value="pengguna" {{ $data->role_target == 'pengguna' ? 'selected' : '' }}>Pengguna
                        </option>
                    </select>
                    <small class="text-danger error-text" id="error-role_target"></small>
                </div>

                {{-- Jenis Pertanyaan --}}
                <div class="form-group">
                    <label for="jenis_pertanyaan"><i class="mdi mdi-format-list-checks"></i> Jenis Pertanyaan</label>
                    <select name="jenis_pertanyaan" class="form-control form-control-lg">
                        <option value="">- Pilih Jenis -</option>
                        <option value="isian" {{ $data->jenis_pertanyaan == 'isian' ? 'selected' : '' }}>Isian</option>
                        <option value="pilihan_ganda"
                            {{ $data->jenis_pertanyaan == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                        <option value="skala" {{ $data->jenis_pertanyaan == 'skala' ? 'selected' : '' }}>Skala</option>
                        <option value="ya_tidak" {{ $data->jenis_pertanyaan == 'ya_tidak' ? 'selected' : '' }}>Ya /
                            Tidak</option>
                    </select>
                    <small class="text-danger error-text" id="error-jenis_pertanyaan"></small>
                </div>

                {{-- Kategori --}}
                <div class="form-group">
                    <label for="kode_kategori"><i class="mdi mdi-tag-multiple"></i> Kategori</label>
                    <select name="kode_kategori" class="form-control form-control-lg">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->kode_kategori }}"
                                {{ $data->kode_kategori == $k->kode_kategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-danger error-text" id="error-kode_kategori"></small>
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

        $('.error-text').text('');

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire('Berhasil', response.message, 'success');

                    // reload kedua Tabel// Reload kedua tabel
                    $('#pertanyaan-pengguna-table').DataTable().ajax.reload();
                    $('#pertanyaan-alumni-table').DataTable().ajax.reload();
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

<form id="form-edit" action="{{ url('/kategori_pertanyaan/' . $data->kode_kategori . '/update_ajax') }}" method="POST">
    @csrf
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="mdi mdi-pencil-box-outline"></i> Edit Kategori Pertanyaan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Kode Kategori --}}
                <div class="form-group">
                    <label for="kode_kategori"><i class="mdi mdi-barcode"></i> Kode Kategori</label>
                    <input type="text" name="kode_kategori" class="form-control form-control-lg" value="{{ $data->kode_kategori }}" placeholder="Masukkan kode kategori">
                    <small class="text-danger error-text" id="error-kode_kategori"></small>
                </div>

                {{-- Nama Kategori --}}
                <div class="form-group">
                    <label for="nama_kategori"><i class="mdi mdi-format-title"></i> Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control form-control-lg" value="{{ $data->nama_kategori }}" placeholder="Masukkan nama kategori">
                    <small class="text-danger error-text" id="error-nama_kategori"></small>
                </div>

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label for="deskripsi"><i class="mdi mdi-text-subject"></i> Deskripsi</label>
                    <textarea name="deskripsi" class="form-control form-control-lg" rows="3" placeholder="Masukkan deskripsi">{{ $data->deskripsi }}</textarea>
                    <small class="text-danger error-text" id="error-deskripsi"></small>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="mdi mdi-content-save"></i> Perbarui
                </button>
                <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">
                    <i class="mdi mdi-close-circle-outline"></i> Batal
                </button>
            </div>
        </div>
    </div>
</form>


<script>
    $('#form-edit').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let url = $(this).attr('action');

        $('.error-text').text('');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire('Sukses', response.message, 'success');
                    $('#kategori_pertanyaan_table').DataTable().ajax.reload();
                } else {
                    $.each(response.msgField, function(key, value) {
                        $('#error-' + key).text(value[0]);
                    });
                }
            },
            error: function() {
                Swal.fire('Gagal', 'Terjadi kesalahan saat update data', 'error');
            }
        });
    });
</script>

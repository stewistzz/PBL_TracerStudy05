<div class="modal-header">
    <h5 class="modal-title">Edit Data Pengguna Lulusan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span>×</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="{{ $pengguna->nama }}" required>
    </div>
    <div class="form-group mb-3">
        <label>Instansi</label>
        <input type="text" name="instansi" class="form-control" value="{{ $pengguna->instansi }}" required>
    </div>
    <div class="form-group mb-3">
        <label>Jabatan</label>
        <input type="text" name="jabatan" class="form-control" value="{{ $pengguna->jabatan }}" required>
    </div>
    <div class="form-group mb-3">
        <label>No. HP</label>
        <input type="text" name="no_hp" class="form-control" value="{{ $pengguna->no_hp }}" required>
    </div>
    <div class="form-group mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $pengguna->email }}" required>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success" id="btn-submit">Update</button>
    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
</div>

<script>
    $('#form-data').attr('action', '{{ route('data_pengguna.update', $pengguna->pengguna_id) }}');
    $('#form-data').attr('method', 'POST');
</script>
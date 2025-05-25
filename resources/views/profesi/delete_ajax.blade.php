<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Konfirmasi Hapus Data</h5>
            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus profesi <strong>{{ $data->nama_profesi }}</strong>?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger" onclick="deleteProfesi({{ $data->profesi_id }})">Hapus</button>
        </div>
    </div>
</div>

<script>
    function deleteProfesi(id) {
        $.ajax({
            url: `/profesi/${id}/delete_ajax`,
            type: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.status) {
                    $('#myModal').modal('hide');
                    $('#profesi-table').DataTable().ajax.reload(null, false);
                    alert(res.message);
                } else {
                    alert(res.message);
                }
            },
            error: function(xhr) {
                alert("Terjadi kesalahan saat menghapus data.");
            }
        });
    }
</script>

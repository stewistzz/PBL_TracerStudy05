<form action="{{ url('/user/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import User</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>File Excel</label>
                    <input type="file" name="file_user" class="form-control" required>
                    <small id="error-file_user" class="text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-import').submit(function(e) {
            e.preventDefault();
            let form = this;
            let formData = new FormData(form);
            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status) {
                        $('#myModal').modal('hide');
                        Swal.fire('Sukses', res.message, 'success').then(() => location
                            .reload());
                    } else {
                        $('#error-file_user').text(res.msgField?.file_user ?? res.message);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Gagal mengimpor data.', 'error');
                }
            });
        });
    });
</script>

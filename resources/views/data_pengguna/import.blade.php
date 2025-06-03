<form action="{{ url('/data_pengguna/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>File Excel</label>
                    <input type="file" name="file_pengguna" class="form-control" accept=".xlsx,.xls" required>
                    <small id="error-file_pengguna" class="text-danger"></small>
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

            // Show loading
            Swal.fire({
                title: 'Sedang mengimpor data...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();
                    if (res.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            if (typeof loadTable === 'function') {
                                loadTable();
                            } else {
                                location.reload();
                            }
                        });
                    } else {
                        // Clear previous errors
                        $('#error-file_pengguna').text('');

                        // Show validation errors
                        if (res.msgField && res.msgField.file_pengguna) {
                            $('#error-file_pengguna').text(res.msgField.file_pengguna);
                        } else {
                            $('#error-file_pengguna').text(res.message);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Import Gagal!',
                            text: res.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let message = 'Gagal mengimpor data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: message
                    });
                }
            });
        });
    });
</script>
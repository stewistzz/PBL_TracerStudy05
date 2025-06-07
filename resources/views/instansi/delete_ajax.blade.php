<div class="modal-header bg-danger text-white">
    <h5 class="modal-title" id="modalLabel">Konfirmasi Penghapusan</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <p>Yakin ingin menghapus data instansi <strong>{{ $instansi->nama_instansi }}</strong>?</p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-danger btn-confirm-delete" data-id="{{ $instansi->instansi_id }}">Hapus</button>
</div>

<script>
    $(document).ready(function() {
        // Event listener untuk tombol Hapus
        $(document).off('click', '.btn-confirm-delete').on('click', '.btn-confirm-delete', function() {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route('instansi.delete', ':id') }}'.replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(res) {
                    $('#modal-form').modal('hide');
                    window.loadTable();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(err) {
                    console.log('Delete Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err.responseJSON.message || 'Gagal menghapus data!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Event listener untuk tombol Batal
        $(document).off('click', '.btn-cancel').on('click', '.btn-cancel', function() {
            $('#modal-form').modal('hide'); // Menutup modal secara manual
        });
    });
</script>
@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Data Instansi</h4>
        <p class="card-description">
            Kelola data instansi dengan mudah
        </p>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-primary" id="btn-tambah">Tambah Instansi</button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table" id="instansi-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Instansi</th>
                        <th>Jenis</th>
                        <th>Skala</th>
                        <th>Lokasi</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Akan diisi AJAX -->
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
window.loadTable = function() {
    $('#instansi-table').DataTable().ajax.reload();
};

$(document).ready(function () {
    let table = $('#instansi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('instansi.list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama_instansi', name: 'nama_instansi' },
            { data: 'jenis_instansi', name: 'jenis_instansi' },
            { data: 'skala', name: 'skala' },
            { data: 'lokasi', name: 'lokasi' },
            { data: 'alamat', name: 'alamat' },
            { data: 'no_telpon', name: 'no_telpon' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Tombol Tambah
    $('#btn-tambah').click(function () {
        $.get('{{ route("instansi.create") }}', function (res) {
            console.log('Create Response:', res); // Debug
            $('#modal-form .modal-content').html(res);
            $('#modal-form').modal('show');
        });
    });

    // Tombol Edit
    $('#instansi-table').on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        $.get('{{ route("instansi.edit", ":id") }}'.replace(':id', id), function (res) {
            console.log('Edit Response:', res); // Debug
            $('#modal-form .modal-content').html(res);
            $('#modal-form').modal('show');
        });
    });

    // Tombol Hapus
    $('#instansi-table').on('click', '.btn-hapus', function () {
        if (confirm("Yakin ingin menghapus data ini?")) {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route("instansi.destroy", ":id") }}'.replace(':id', id),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (res) {
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        confirmButtonText: 'OK'
                    });
                },
                error: function (err) {
                    console.log('Delete Error:', err); // Debug
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal menghapus data!'
                    });
                }
            });
        }
    });
});
</script>
@endpush
@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Data Alumni</h4>
        <p class="card-description">
            Kelola data alumni dengan mudah
        </p>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-primary" id="btn-tambah">Tambah Alumni</button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table" id="alumni-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Program Studi</th>
                        <th>Tahun Lulus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Akan diisi AJAX -->
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
window.loadTable = function() {
    $('#alumni-table').DataTable().ajax.reload();
};

$(document).ready(function () {
    let table = $('#alumni-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('alumni.list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'user_name', name: 'user_name' },
            { data: 'nama', name: 'nama' },
            { data: 'nim', name: 'nim' },
            { data: 'email', name: 'email' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'program_studi', name: 'program_studi' },
            { data: 'tahun_lulus_formatted', name: 'tahun_lulus' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Tombol Tambah
    $('#btn-tambah').click(function () {
        $.get('{{ route("alumni.create") }}', function (res) {
            console.log('Create Response:', res);
            $('#modal-form .modal-content').html(res);
            $('#modal-form').modal('show');
        });
    });

    // Tombol Edit
    $('#alumni-table').on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        $.get('{{ route("alumni.edit", ":id") }}'.replace(':id', id), function (res) {
            console.log('Edit Response:', res);
            $('#modal-form .modal-content').html(res);
            $('#modal-form').modal('show');
        });
    });

    // Tombol Hapus
    $('#alumni-table').on('click', '.btn-hapus', function () {
        if (confirm("Yakin ingin menghapus data ini?")) {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route("alumni.destroy", ":id") }}'.replace(':id', id),
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
                    console.log('Delete Error:', err);
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
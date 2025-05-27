@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold">Data User</h3>
            <hr>
            <p class="card-description">
                Halaman Data User memungkinkan admin untuk mengelola informasi pengguna dalam sistem Tracer Study,
                seperti menambahkan, memperbarui, atau menghapus akun.
                Setiap pengguna dapat diberi peran tertentu sesuai kebutuhan,
                sehingga pengelolaan akses dan data menjadi lebih tertata dan efisien.
            </p>
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-info d-flex align-items-center gap-1" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data User
                </button>
            </div>

            <div class="table-responsive">
                <table class="table" id="users-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-data">
                <div class="modal-content">
                    <!-- Konten modal diisi via AJAX -->
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        window.loadTable = function() {
            $('#users-table').DataTable().ajax.reload();
        };

        $(document).ready(function() {
            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#btn-tambah').click(function() {
                $.get('{{ route('user.create') }}', function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            $('#users-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('user.edit', ':id') }}'.replace(':id', id), function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            $('#users-table').on('click', '.btn-hapus', function() {
                if (confirm("Yakin ingin menghapus data ini?")) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('user.destroy', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function() {
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

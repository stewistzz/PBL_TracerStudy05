@extends('layouts.template')

@section('content')
<div class="card shadow-sm border-0 mb-4" style="position: relative; z-index: 0;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-database-plus me-1"></i> Manajemen Data Users
                </h4>
            </div>
            <hr>
            <p class="card-description text-muted">
                Halaman Data User memungkinkan admin untuk mengelola informasi pengguna dalam sistem Tracer Study,
                seperti menambahkan, memperbarui, atau menghapus akun.
                Setiap pengguna dapat diberi peran tertentu sesuai kebutuhan,
                sehingga pengelolaan akses dan data menjadi lebih tertata dan efisien.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold">Data User</h3>
            <hr>
            <div class="row">
                <div class="col-8">
                    <p class="card-description">
                        Tabel ini menampilkan daftar Users terkait Tracer Study.
                    </p>
                </div>
                <div class="col-4">
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <!-- Tombol Import -->
                        <button class="btn btn-primary btn-sm mr-2 gap-2" onclick="modalAction('{{ url('/user/import') }}')">
                            <i class="fa fa-upload mr-2"></i> Import User
                        </button>
        
                        <!-- Tombol Tambah (rata kanan) -->
                        <button class="btn btn-sm d-flex align-items-center gap-2 text-light" id="btn-tambah" style="background-color: #5BAEB7;">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data User
                        </button>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table" id="users-table" >
                    <thead class="thead-dark">
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
    <!-- Placeholder Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url) {
            $.get(url, function(res) {
                $('#myModal').html(res); // Masukkan isi modal
                $('#myModal').modal('show'); // Tampilkan modal
            });
        }
        window.loadTable = function() {
            $('#users-table').DataTable().ajax.reload();
        };

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

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

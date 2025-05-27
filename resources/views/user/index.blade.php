@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data User</h4>
            <p class="card-description">
                Kelola data user dengan mudah
            </p>
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-sm btn-primary d-flex align-items-center gap-1" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5"></i>
                    Tambah Data User
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
                    <!-- Isi modal akan diisi oleh AJAX -->
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Fungsi loadTable dibuat global agar bisa diakses oleh create_ajax dan edit_ajax
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
                    console.log('Create Response:', res); // Debug
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            $('#users-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('user.edit', ':id') }}'.replace(':id', id), function(res) {
                    console.log('Edit Response:', res); // Debug
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
                        error: function(err) {
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

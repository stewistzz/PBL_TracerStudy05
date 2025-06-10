@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Admin</h4>
            <hr>
            <p class="card-description">
                Halaman ini menampilkan informasi lengkap mengenai akun administrator sistem, termasuk nama, email, peran,
                serta status aktif. Data ini digunakan untuk mengelola akses dan memastikan hanya pengguna yang berwenang
                dapat melakukan tindakan administratif pada sistem.
            </p>
            <div class="d-flex justify-content-end mb-3">
                {{-- <button class="btn btn-sm btn-success" id="btn-tambah">+ Tambah admin</button> --}}
                <button class="btn d-flex align-items-center gap-2 text-light" id="btn-tambah"
                    style="background-color: #5BAEB7;">
                    <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data Admin
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table" id="admin-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Email</th>
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
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        window.loadTable = function() {
            $('#admin-table').DataTable().ajax.reload();
        };

        $(document).ready(function() {
            let table = $('#admin-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        classname: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user.username',
                        classname: ''
                    },
                    {
                        data: 'nama',
                        classname: ''
                    },
                    {
                        data: 'email',
                        classname: ''
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Tombol Tambah
            $('#btn-tambah').click(function() {
                $.get('{{ route('admin.create') }}', function(res) {
                    console.log('Create Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Edit
            $('#admin-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('admin.edit', ':id') }}'.replace(':id', id), function(res) {
                    console.log('Edit Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Hapus
            $('#admin-table').on('click', '.btn-hapus', function() {
                if (confirm("Yakin ingin menghapus data ini?")) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('admin.destroy', ':id') }}'.replace(':id', id),
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

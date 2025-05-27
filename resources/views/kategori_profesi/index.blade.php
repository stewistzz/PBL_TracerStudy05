@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Kategori Profesi</h4>
            <p class="card-description">
                Kelola data kategori profesi dengan mudah
            </p>
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-sm btn-primary d-flex align-items-center gap-1" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5"></i>
                    Tambah Kategori
                </button>
            </div>


            <div class="table-responsive">
                <table class="table" id="kategori-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
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
            $('#kategori-table').DataTable().ajax.reload();
        };

        $(document).ready(function() {
            let table = $('#kategori-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kategori_profesi.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_kategori',
                        name: 'nama_kategori'
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
                $.get('{{ route('kategori_profesi.create') }}', function(res) {
                    console.log('Create Response:', res); // Debug
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            $('#kategori-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('kategori_profesi.edit', ':id') }}'.replace(':id', id), function(res) {
                    console.log('Edit Response:', res); // Debug
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            $('#kategori-table').on('click', '.btn-hapus', function() {
                if (confirm("Yakin ingin menghapus data ini?")) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('kategori_profesi.destroy', ':id') }}'.replace(':id', id),
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
@extends('layouts.template')
<link rel="stylesheet" href="{{ asset('skydash/template/css/styletambah.css') }}">

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold">Data Pengguna Lulusan</h3>
            <hr>
            <p class="card-description">
                Kelola data pengguna lulusan dengan mudah dan efisien. Fitur ini memungkinkan Anda untuk menambahkan,
                mengedit,
                serta menghapus data pengguna lulusan sesuai kebutuhan, sehingga mempermudah pengelolaan data alumni dan
                pelaporan.
            </p>
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-info d-flex align-items-center gap-1" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5 me-2"></i>
                    Tambah Data
                </button>
            </div>


            <div class="table-responsive">
                <table class="table" id="data-pengguna-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Jabatan</th>
                            <th>No. HP</th>
                            <th>Email</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- data alumni yang belum mengisi --}}
    <div class="col-12 grid-margin stretch-card mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pengguna Belum Mengisi Survey Kepuasan</h4>
                <p class="card-description text-muted">Berikut ini adalah Pengguna Lulusan atausan yang belum mengisi survey kepuasan 
                    POLINEMA</p>

                {{-- export --}}
                <a href="{{ route('data_pengguna.export_belum_isi') }}" class="btn btn-warning btn-sm"><i
                        class="mdi mdi-file-excel"></i> Export ke Excel</a>

                <div class="d-flex justify-content-between align-items-center mb-3">

                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="survey-table-belum-isi">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Instansi</th>
                                <th>Jabatan</th>
                                <th>No. HP</th>
                                <th>Email</th>
                                <th>Status</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                    </table>
                </div>
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
            $('#data-pengguna-table').DataTable().ajax.reload();
        };

        $(document).ready(function() {
            let table = $('#data-pengguna-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data_pengguna.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'instansi',
                        name: 'instansi'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            $('#btn-tambah').click(function() {
                $.get('{{ route('data_pengguna.create') }}', function(res) {
                    console.log('Create Response:', res); // Debug
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            $('#data-pengguna-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('data_pengguna.edit', ':id') }}'.replace(':id', id), function(res) {
                    console.log('Edit Response:', res); // Debug
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            $('#data-pengguna-table').on('click', '.btn-hapus', function() {
                if (confirm("Yakin ingin menghapus data ini?")) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('data_pengguna.destroy', ':id') }}'.replace(':id', id),
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

            // Event handler untuk submit form (create/update)
            $(document).on('submit', '#form-data', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let url = $(this).attr('action');
                let method = $(this).attr('method') || 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.status) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            let errorMsg = '';
                            $.each(errors, function(key, value) {
                                errorMsg += value[0] + '\n';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Error',
                                text: errorMsg
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan!'
                            });
                        }
                    }
                });
            });
        });
    </script>
    {{-- script pengguna yang belum mengisi --}}
    <script>
        $(document).ready(function() {
            $('#survey-table-belum-isi').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data_pengguna.belum_isi') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'instansi',
                        name: 'instansi'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush

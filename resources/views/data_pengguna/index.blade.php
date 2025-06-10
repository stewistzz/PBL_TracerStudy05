@extends('layouts.template')
<link rel="stylesheet" href="{{ asset('skydash/template/css/styletambah.css') }}">

@section('content')
    {{-- header --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-briefcase-outline me-1"></i> Data Pengguna Lulusan
                </h4>
            </div>
            <hr>
            <p class="card-description text-muted">
                Tabel ini menampilkan data dari pengguna alumni dari data yang diinputkan oleh alumni.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold">Data Pengguna Lulusan</h3>
            <hr>
            <div class="row">
                <div class="col-7">
                    <p class="card-description">
                        Kelola data pengguna lulusan dengan mudah dan efisien. Fitur ini memungkinkan Anda untuk menambahkan,
                        mengedit,serta menghapus data pengguna lulusan sesuai kebutuhan.
                    </p>
                </div>
                <div class="col-5">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn d-flex align-items-center gap-1 btn-sm text-white mr-2" onclick="modalAction('{{ route('data_pengguna.import') }}')" style="background-color: #5BAEB7;">
                            <i class="fa fa-upload fs-5 mr-2"></i> Import User
                        </button>
        
                        <button class="btn d-flex align-items-center gap-1 btn-sm text-white" id="btn-tambah" style="background-color: #5BAEB7;">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data User
                        </button>
                    </div>
                </div>
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
                <p class="card-description text-muted">Berikut ini adalah Pengguna Lulusan atausan yang belum mengisi survey
                    kepuasan
                    POLINEMA</p>

                {{-- export --}}
                <a href="{{ route('data_pengguna.export_belum_isi') }}" class="btn btn-warning btn-sm"><i
                        class="mdi mdi-file-excel"></i> Export ke Excel</a>

                <div class="d-flex justify-content-between align-items-center mb-3"></div>

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
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tambah/Edit -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-data">
                <div class="modal-content">
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Import -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').html('');
            $('#myModal').load(url, function(response, status, xhr) {
                if (status == "error") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat!',
                        text: 'Tidak dapat memuat konten modal. Silakan coba lagi. (' + xhr.status + ' ' +
                            xhr.statusText + ')'
                    });
                } else {
                    $('#myModal').modal('show');
                }
            });
        }

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
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Gagal memuat form tambah data.'
                    });
                });
            });

            $('#data-pengguna-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('data_pengguna.edit', ':id') }}'.replace(':id', id), function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Gagal memuat form edit.'
                    });
                });
            });

            $('#data-pengguna-table').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('data_pengguna.destroy', ':id') }}'.replace(
                                ':id', id),
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Tidak dapat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('submit', '#form-data', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let url = $(this).attr('action');
                let method = $(this).find('input[name="_method"]').val() || 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.status) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message
                            });
                        } else {
                            let errorMsg = 'Validasi gagal.';
                            if (res.errors) {
                                errorMsg = Object.values(res.errors).map(v => v[0]).join('\n');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Error!',
                                text: errorMsg
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            message = Object.values(xhr.responseJSON.errors).map(v => v[0])
                                .join('\n');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message
                        });
                    }
                });
            });

            $('#modal-form').on('hidden.bs.modal', function() {
                $(this).find('.modal-content').html('');
            });

            $('#myModal').on('hidden.bs.modal', function() {
                $(this).html('');
            });
        });
    </script>

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

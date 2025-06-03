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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-success" onclick="modalAction('{{ route('data_pengguna.import') }}')">
                    <i class="fa fa-upload mr-2"></i> Import User
                </button>

                <button class="btn btn-info d-flex align-items-center gap-2" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data User
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

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-data">
                <div class="modal-content">
                </div>
            </form>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
@endsection

@push('js')
    <script>
        // Function to load content into #myModal and show it
        // This should ideally be in a global JS file or layout if used by multiple pages.
        function modalAction(url = '') {
            $('#myModal').html(''); // Clear previous content
            $('#myModal').load(url, function(response, status, xhr) {
                if (status == "error") {
                    console.error("Error loading modal content:", xhr.status, xhr.statusText);
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

        // Global function to reload DataTable (can be called from import modal script)
        window.loadTable = function() {
            $('#data-pengguna-table').DataTable().ajax.reload();
        };

        $(document).ready(function() {
            // Initialize DataTable for Data Pengguna
            let table = $('#data-pengguna-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('data_pengguna.list') }}",
                    type: "GET",
                    error: function(xhr, error, code) {
                        console.error('DataTable Ajax Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal memuat data. Silakan refresh halaman.'
                        });
                    }
                },
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

            // Handler untuk button tambah (create)
            $('#btn-tambah').click(function() {
                $.get('{{ route('data_pengguna.create') }}', function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                }).fail(function(xhr) {
                    console.error('Failed to load create form:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Gagal memuat form tambah data: ' + (xhr.responseJSON
                            ?.message || xhr.statusText)
                    });
                });
            });

            // Handler untuk button edit
            $('#data-pengguna-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('data_pengguna.edit', ':id') }}'.replace(':id', id), function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                }).fail(function(xhr) {
                    console.error('Failed to load edit form:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Gagal memuat form edit: ' + (xhr.responseJSON?.message || xhr
                            .statusText)
                    });
                });
            });

            // Handler untuk button hapus
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
                                    text: res.message,
                                    confirmButtonText: 'OK'
                                });
                            },
                            error: function(xhr) {
                                console.error('Delete error:', xhr);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal menghapus data: ' + (xhr
                                        .responseJSON?.message || xhr
                                        .statusText)
                                });
                            }
                        });
                    }
                });
            });

            // Event handler untuk submit form (HANYA UNTUK CREATE/UPDATE via #form-data)
            $(document).on('submit', '#form-data', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let url = $(this).attr('action');
                let method = $(this).find('input[name="_method"]').val() ||
                'POST'; // Check for method spoofing

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
                                text: res.message,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            let errorMsg = res.message || 'Terjadi kesalahan';
                            if (res.errors) { // Standard Laravel validation errors
                                errorMsg = '';
                                $.each(res.errors, function(key, value) {
                                    errorMsg += (Array.isArray(value) ? value[0] :
                                        value) + '\n';
                                });
                            } else if (res.msgField) { // Legacy or specific structure
                                errorMsg = '';
                                $.each(res.msgField, function(key, value) {
                                    errorMsg += (Array.isArray(value) ? value[0] :
                                        value) + '\n';
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Error!',
                                text: errorMsg.trim()
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Form submit error:', xhr);
                        let message = 'Terjadi kesalahan.';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                message = '';
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    message += (Array.isArray(value) ? value[0] :
                                        value) + '\n';
                                });
                            } else if (xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message.trim()
                        });
                    }
                });
            });

            // Reset #modal-form (create/edit modal) when closed
            $('#modal-form').on('hidden.bs.modal', function() {
                $(this).find('.modal-content').html('');
                // Optional: Clear any validation messages if they are outside modal-content
            });

            // Reset #myModal (import modal) when closed
            $('#myModal').on('hidden.bs.modal', function() {
                $(this).html(''); // Clear loaded content
            });
        });
    </script>
@endpush

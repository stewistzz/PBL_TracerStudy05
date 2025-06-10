@extends('layouts.template')

@section('content')
    <div class="card shadow-sm border-0 mb-4" style="background-color: #FFFFFF;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-format-list-bulleted-square me-2"></i>
                    Manajemen Data Kategori Profesi
                </h4>
            </div>
            <hr>
            <p class="text-muted mb-0" style="color: #9B9B9B;">
                Kelola data kategori profesi dengan mudah untuk mendukung pengelompokan berbagai jenis pekerjaan secara
                terstruktur. Fitur ini memungkinkan Anda menambahkan, mengedit, dan menghapus kategori profesi sesuai
                kebutuhan, sehingga mempermudah pengelolaan data tenaga kerja, penyaringan informasi, dan pelaporan.
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="background-color: #FFFFFF;">
        <div class="card-body">
            <h5 class="card-title" style="color: #2A3143;">Tabel Data Kategori Profesi</h5>
            <hr>
            <div class="row">
                <div class="col-9">
                    <p class="card-description">
                        Tabel ini menampilkan isi data dari jenis atau kategori profesi terkait dalam kebutuhan pengumpulan
                        informasi mengenai Tracer Study.
                    </p>
                </div>
                <div class="col-3">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn d-flex align-items-center gap-2 text-light"
                            style="background-color: #5BAEB7;" id="btn-tambah">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Kategori
                        </button>
                    </div>

                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="kategori-table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Kategori</th>
                            <th class="text-center" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat melalui AJAX -->
                    </tbody>
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

            // Tombol Tambah
            $(document).off('click', '#btn-tambah').on('click', '#btn-tambah', function() {
                console.log('Tombol Tambah diklik');
                $.get('{{ route('kategori_profesi.create') }}', function(res) {
                    console.log('Create Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Edit
            $(document).off('click', '.btn-edit').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                let url = '{{ route('kategori_profesi.edit', ':id') }}'.replace(':id', id);
                console.log('Edit URL:', url);
                $.get(url, function(res) {
                    console.log('Edit Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Hapus
            $(document).off('click', '.btn-hapus').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                let url = '{{ route('kategori_profesi.confirm', ':id') }}'.replace(':id', id);
                console.log('Confirm Delete URL:', url);
                $.get(url, function(res) {
                    console.log('Confirm Delete Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Bersihkan event listener dan modal saat ditutup
            $('#modal-form').on('hidden.bs.modal', function() {
                console.log('Modal ditutup, membersihkan konten dan event');
                $('#modal-form .modal-content').empty();
                $('#form-data').off('submit');
            });
        });
    </script>
@endpush

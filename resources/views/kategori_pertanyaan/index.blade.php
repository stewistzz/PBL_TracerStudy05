@extends('layouts.template')

@section('content')
    <!-- Card Header -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-format-list-bulleted-square me-1"></i> Manajemen Data Kategori Pertanyaan
                </h4>
                {{-- <button onclick="modalAction('{{ route('kategori_pertanyaan.create_ajax') }}')"
                    class="btn btn-sm btn-primary shadow">
                    <i class="mdi mdi-plus-circle-outline"></i> Tambah Pertanyaan
                </button> --}}
            </div>
            <p class="card-description text-muted">Kelola kategori pertanyaan untuk <strong>Alumni</strong> dan
                <strong>Pengguna</strong>.</p>
        </div>
    </div>

    <!-- Tabel Kategori -->
    <div class="card shadow-sm border-left-primary mb-4">
        <div class="card-body">
            <h5 class="card-title" style="color: #2A3143;">
                <i class="mdi mdi-table-large me-2"></i> Data Kategori Pertanyaan
            </h5>
            {{-- modifikasi --}}
            <hr>
            {{-- modifikasi untuk penambahan masing-masing tombol tambah --}}
            <div class="row">
                <div class="col-9">
                    <p class="card-description">
                        Kelola pertanyaan untuk role target dari alumni
                    </p>
                </div>
                <div class="col-3">
                    <div class="d-flex justify-content-end mb-3">
                        <button onclick="modalAction('{{ route('kategori_pertanyaan.create_ajax') }}')"
                            style="background-color: #5BAEB7;" class="btn btn-sm d-flex align-items-center gap-2 text-white"
                            id="btn-tambah">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
            {{-- end modifikasi --}}
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover table-bordered align-middle" id="kategori_pertanyaan_table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th class="text-end">Kode Kategori</th>
                            <th class="text-end">Nama Kategori</th>
                            <th class="text-end">Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            $('#kategori_pertanyaan_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kategori_pertanyaan.list') }}",
                columns: [{
                        data: 'kode_kategori',
                        name: 'kode_kategori',
                        className: 'text-end'
                    },
                    {
                        data: 'nama_kategori',
                        name: 'nama_kategori',
                        className: 'text-end'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi',
                        className: 'text-end'
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
        });
    </script>
@endpush

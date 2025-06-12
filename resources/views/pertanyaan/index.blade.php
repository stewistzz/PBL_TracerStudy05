@extends('layouts.template')

@section('content')
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-database-plus me-1"></i> Manajemen Data Pertanyaan
                </h4>
                {{-- <button onclick="modalAction('{{ route('pertanyaan.create_ajax') }}')" class="btn btn-sm btn-primary shadow">
                    <i class="mdi mdi-plus-circle-outline"></i> Tambah Pertanyaan
                </button> --}}
            </div>
            <hr>
            <p class="card-description text-muted">Tabel ini menampilkan daftar pertanyaan sesuai dengan target role terkait
                dalam kebutuhan pengumpulan
                informasi mengenai Tracer Study.</p>
        </div>
    </div>

    {{-- Card: Alumni --}}
    <div class="card shadow-sm border-left-primary mb-4">
        <div class="card-body">
            <h5 class="card-title" style="color: #2A3143;"><i class="mdi mdi-account-tie me-1"></i> Data Pertanyaan untuk
                Alumni</h5>
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
                        <button onclick="modalAction('{{ route('pertanyaan.create_ajax') }}')"
                            class="btn btn-sm d-flex align-items-center gap-2 text-light" id="btn-tambah"
                            style="background-color: #5BAEB7;">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>

            {{-- end modifikasi --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="pertanyaan-alumni-table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th>No</th>
                            <th>Isi Pertanyaan</th>
                            <th>Jenis</th>
                            <th>Role Target</th>
                            <th>Kategori</th>
                            <th>Admin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Card: Pengguna --}}
    <div class="card shadow-sm border-left-success mb-4">
        <div class="card-body">
            <h5 class="card-title" style="color: #2A3143;"><i class="mdi mdi-account-multiple me-1"></i> Data Pertanyaan
                untuk Pengguna
            </h5>
            {{-- tambah pertanyaan --}}
            <hr>
            {{-- modifikasi untuk penambahan masing-masing tombol tambah --}}
            <div class="row">

                <div class="col-9">
                    <p class="card-description">
                        Kelola pertanyaan untuk role target dari pengguna lulusan atau atasan
                    </p>
                </div>
                <div class="col-3">
                    <div class="d-flex justify-content-end mb-3">
                        <button onclick="modalAction('{{ route('pertanyaan.create_ajax') }}')"
                            class="btn btn-sm d-flex align-items-center gap-2 text-light" id="btn-tambah"
                            style="background-color: #5BAEB7;">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="pertanyaan-pengguna-table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th>No</th>
                            <th>Isi Pertanyaan</th>
                            <th>Jenis</th>
                            <th>Role Target</th>
                            <th>Kategori</th>
                            <th>Admin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

        {{-- Modal --}}
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"></div>
    @endsection

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function() {
                    $('#myModal').modal('show');
                });
            }

            const renderRoleBadge = (role) => {
                if (role === 'alumni') {
                    return `<span class="badge badge-outline-primary">Alumni</span>`;
                } else if (role === 'pengguna') {
                    return `<span class="badge badge-outline-success">Pengguna</span>`;
                } else {
                    return `<span class="badge badge-outline-secondary">${role}</span>`;
                }
            };

            $(document).ready(function() {
                // Tabel Alumni
                $('#pertanyaan-alumni-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pertanyaan.list') }}?role_target=alumni",
                    columns: [{
                            data: 'pertanyaan_id',
                            name: 'pertanyaan_id'
                        },
                        {
                            data: 'isi_pertanyaan',
                            name: 'isi_pertanyaan'
                        },
                        {
                            data: 'jenis_pertanyaan',
                            name: 'jenis_pertanyaan'
                        },
                        {
                            data: 'role_target',
                            name: 'role_target',
                            render: function(data) {
                                return renderRoleBadge(data);
                            }
                        },
                        {
                            data: 'kategori',
                            name: 'kategori'
                        },
                        {
                            data: 'admin',
                            name: 'admin'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Tabel Pengguna
                $('#pertanyaan-pengguna-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pertanyaan.list') }}?role_target=pengguna",
                    columns: [{
                            data: 'pertanyaan_id',
                            name: 'pertanyaan_id'
                        },
                        {
                            data: 'isi_pertanyaan',
                            name: 'isi_pertanyaan'
                        },
                        {
                            data: 'jenis_pertanyaan',
                            name: 'jenis_pertanyaan'
                        },
                        {
                            data: 'role_target',
                            name: 'role_target',
                            render: function(data) {
                                return renderRoleBadge(data);
                            }
                        },
                        {
                            data: 'kategori',
                            name: 'kategori'
                        },
                        {
                            data: 'admin',
                            name: 'admin'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    @endpush

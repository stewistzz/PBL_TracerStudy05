@extends('layouts.template')

@section('content')
    {{-- Page header --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0 text-secondary">
                    <i class="mdi mdi-database-plus me-1"></i> Manajemen Data Pertanyaan
                </h4>
            </div>

            <p class="card-description text-muted">
                Tabel ini menampilkan daftar pertanyaan sesuai dengan target role dalam Tracer Study.
            </p>
        </div>
    </div>

    {{-- Card: Alumni --}}
    <div class="card shadow-sm border-left-primary mb-4">
        <div class="card-body">
            <h5 class="card-title text-secondary">
                <i class="mdi mdi-account-tie me-1"></i> Data Pertanyaan untuk Alumni
            </h5>
            <hr>

            <div class="row">
                <div class="col-md-9">
                    <p class="card-description">Kelola pertanyaan khusus target alumni.</p>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-end mb-3">
                        <button
                            id="btn-add-alumni"
                            class="btn text-light d-flex align-items-center gap-2"
                            style="background-color:#5BAEB7"
                            onclick="modalAction('{{ route('pertanyaan.create_ajax') }}')">
                            <i class="mdi mdi-plus-circle-outline fs-5"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="pertanyaan-alumni-table" class="table table-hover table-bordered">
                    <thead class="text-white" style="background-color:#1E80C1">
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
            <h5 class="card-title text-secondary">
                <i class="mdi mdi-account-multiple me-1"></i> Data Pertanyaan untuk Pengguna
            </h5>
            <hr>

            <div class="row">
                <div class="col-md-9">
                    <p class="card-description">
                        Kelola pertanyaan untuk pengguna lulusan atau atasan.
                    </p>
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-end mb-3">
                        <button
                            id="btn-add-pengguna"
                            class="btn text-light d-flex align-items-center gap-2"
                            style="background-color:#5BAEB7"
                            onclick="modalAction('{{ route('pertanyaan.create_ajax') }}')">
                            <i class="mdi mdi-plus-circle-outline fs-5"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="pertanyaan-pengguna-table" class="table table-hover table-bordered">
                    <thead class="text-white" style="background-color:#1E80C1">
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

    {{-- Modal --}}
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"></div>
@endsection

@push('js')
<script>
    const modalAction = (url = '') => {
        $('#myModal').load(url, () => $('#myModal').modal('show'));
    };

    const renderRoleBadge = (role) => {
        const badgeMap = {
            alumni  : 'badge-outline-primary',
            pengguna: 'badge-outline-success'
        };
        const cls = badgeMap[role] ?? 'badge-outline-secondary';
        return `<span class="badge ${cls} text-capitalize">${role}</span>`;
    };

    $(function () {
        const tableConfig = (role) => ({
            processing: true,
            serverSide: true,
            ajax: `{{ route('pertanyaan.list') }}?role_target=${role}`,
            columns: [
                { data: 'pertanyaan_id',  name: 'pertanyaan_id'  },
                { data: 'isi_pertanyaan', name: 'isi_pertanyaan' },
                { data: 'jenis_pertanyaan', name: 'jenis_pertanyaan' },
                {
                    data: 'role_target',
                    name: 'role_target',
                    render: (data) => renderRoleBadge(data)
                },
                { data: 'kategori', name: 'kategori' },
                { data: 'admin',    name: 'admin'    },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#pertanyaan-alumni-table').DataTable(tableConfig('alumni'));
        $('#pertanyaan-pengguna-table').DataTable(tableConfig('pengguna'));
    });
</script>
@endpush

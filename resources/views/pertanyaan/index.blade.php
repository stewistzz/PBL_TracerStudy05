@extends('layouts.template')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0 text-primary">
                <i class="mdi mdi-database-plus me-1"></i> Manajemen Data Pertanyaan
            </h4>
            <button onclick="modalAction('{{ route('pertanyaan.create_ajax') }}')" class="btn btn-sm btn-primary shadow">
                <i class="mdi mdi-plus-circle-outline"></i> Tambah Pertanyaan
            </button>
        </div>
        <p class="card-description text-muted">Kelola data pertanyaan untuk <strong>Alumni</strong> dan <strong>Pengguna</strong>.</p>
    </div>
</div>

{{-- Card: Alumni --}}
<div class="card shadow-sm border-left-primary mb-4">
    <div class="card-body">
        <h5 class="card-title text-primary"><i class="mdi mdi-account-tie me-1"></i> Data Pertanyaan untuk Alumni</h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="pertanyaan-alumni-table">
                <thead class="table-light text-center">
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
        <h5 class="card-title text-success"><i class="mdi mdi-account-multiple me-1"></i> Data Pertanyaan untuk Pengguna</h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="pertanyaan-pengguna-table">
                <thead class="table-light text-center">
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
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
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

    $(document).ready(function () {
        // Tabel Alumni
        $('#pertanyaan-alumni-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pertanyaan.list') }}?role_target=alumni",
            columns: [
                { data: 'pertanyaan_id', name: 'pertanyaan_id' },
                { data: 'isi_pertanyaan', name: 'isi_pertanyaan' },
                { data: 'jenis_pertanyaan', name: 'jenis_pertanyaan' },
                { 
                    data: 'role_target', 
                    name: 'role_target',
                    render: function(data) {
                        return renderRoleBadge(data);
                    }
                },
                { data: 'kategori', name: 'kategori' },
                { data: 'admin', name: 'admin' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Tabel Pengguna
        $('#pertanyaan-pengguna-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pertanyaan.list') }}?role_target=pengguna",
            columns: [
                { data: 'pertanyaan_id', name: 'pertanyaan_id' },
                { data: 'isi_pertanyaan', name: 'isi_pertanyaan' },
                { data: 'jenis_pertanyaan', name: 'jenis_pertanyaan' },
                { 
                    data: 'role_target', 
                    name: 'role_target',
                    render: function(data) {
                        return renderRoleBadge(data);
                    }
                },
                { data: 'kategori', name: 'kategori' },
                { data: 'admin', name: 'admin' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush

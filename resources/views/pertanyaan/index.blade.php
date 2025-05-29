@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Data Pertanyaan</h4>
        <p class="card-description">
            Kelola data pertanyaan dari pengguna/alumni
        </p>

        <div class="d-flex justify-content-end mb-3">
            <button onclick="modalAction('{{ route('pertanyaan.create_ajax') }}')" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-circle-outline"></i> Tambah Pertanyaan
            </button>
        </div>

        <div class="table-responsive mb-4">
            <table class="table text-center" id="pertanyaan-table">
                <thead>
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

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        $('#pertanyaan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pertanyaan.list') }}",
            columns: [
                { data: 'pertanyaan_id', name: 'pertanyaan_id' },
                { data: 'isi_pertanyaan', name: 'isi_pertanyaan' },
                { data: 'jenis_pertanyaan', name: 'jenis_pertanyaan' },
                { data: 'role_target', name: 'role_target' },
                { data: 'kategori', name: 'kategori' },
                { data: 'admin', name: 'admin' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush

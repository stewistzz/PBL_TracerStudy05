@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Data Kategori Pertanyaan</h4>
        <p class="card-description">
            Kelola data kategori dari pertanyaan
        </p>

        <div class="d-flex justify-content-end mb-3">
            <button onclick="modalAction('{{ route('kategori_pertanyaan.create_ajax') }}')" class="btn btn-sm btn-primary">
                <i class="mdi mdi-plus-circle-outline"></i> Tambah Kategori
            </button>
        </div>

        <div class="table-responsive mb-4">
            <table class="table text-center" id="kategori_pertanyaan_table">
                <thead>
                    <tr>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
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
        $('#kategori_pertanyaan_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('kategori_pertanyaan.list') }}",
            columns: [
                { data: 'kode_kategori', name: 'kode_kategori' },
                { data: 'nama_kategori', name: 'nama_kategori' },
                { data: 'deskripsi', name: 'deskripsi' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush

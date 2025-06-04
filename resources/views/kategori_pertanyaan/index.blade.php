@extends('layouts.template')

@section('content')
    <!-- Card Header -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0 text-primary">
                    <i class="mdi mdi-format-list-bulleted-square me-1"></i> Manajemen Data Kategori Pertanyaan
                </h4>
                <button onclick="modalAction('{{ route('kategori_pertanyaan.create_ajax') }}')" class="btn btn-sm btn-primary shadow">
                    <i class="mdi mdi-plus-circle-outline"></i> Tambah Pertanyaan
                </button>
            </div>
            <p class="card-description text-muted">Kelola kategori pertanyaan untuk <strong>Alumni</strong> dan <strong>Pengguna</strong>.</p>
        </div>
    </div>

    <!-- Tabel Kategori -->
    <div class="card shadow-sm border-left-primary mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">
                <i class="mdi mdi-table-large me-2"></i> Data Kategori Pertanyaan
            </h5>
            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover table-bordered align-middle" id="kategori_pertanyaan_table">
                    <thead class="bg-light text-center">
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
                columns: [
                    { data: 'kode_kategori', name: 'kode_kategori', className: 'text-end' },
                    { data: 'nama_kategori', name: 'nama_kategori', className: 'text-end' },
                    { data: 'deskripsi', name: 'deskripsi', className: 'text-end' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });
    </script>
@endpush

@extends('layouts.template')
<link rel="stylesheet" href="{{ asset('skydash/template/css/styletambah.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@section('content')
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-school me-1"></i> Manajemen Data Alumni
                </h4>
            </div>
            <hr>
            <p class="card-description text-muted">
                Kelola data alumni dengan mudah untuk mendukung pencatatan lulusan, pelacakan karier, dan evaluasi hasil
                pendidikan. Fitur ini memungkinkan Anda menambahkan, mengedit, dan menghapus data alumni sesuai kebutuhan,
                sehingga mempermudah pengelolaan informasi alumni secara terstruktur dan efisien.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold" style="color: #2A3143;">Data Alumni</h3>
            <hr>
            {{-- <p class="card-description">
                Kelola data alumni dengan mudah untuk mendukung pencatatan lulusan, pelacakan karier, dan evaluasi hasil
                pendidikan. Fitur ini memungkinkan Anda menambahkan, mengedit, dan menghapus data alumni sesuai kebutuhan,
                sehingga mempermudah pengelolaan informasi alumni secara terstruktur dan efisien.
            </p> --}}
            <div class="row">
                <div class="col-6">
                    <p class="card-description">
                        Kelola Alumni untuk kebutuhan pengisian survey tracer study POLINEMA
                    </p>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" style="background-color: #5BAEB7;" class="btn btn-sm d-flex align-items-center gap-1 text-white" id="btn-tambah">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i>
                            Tambah Alumni
                        </button>
                        <button type="button" style="background-color: #5BAEB7;" class="btn btn-sm d-flex align-items-center gap-1 ms-2 text-white" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            <i class="mdi mdi-filter fs-5 mr-2"></i>
                            Filter
                        </button>
                        <button type="button" style="background-color: #5BAEB7;" class="btn btn-sm d-flex align-items-center gap-1 ms-2 text-white" id="btn-export">
                            <i class="mdi mdi-file-excel fs-5 mr-2"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table" id="alumni-table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Tahun Lulus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk Form Create/Edit/Show -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{-- Konten form (create/edit/show) akan di‐load via AJAX --}}
            </div>
        </div>
    </div>

    <!-- Modal untuk Filter -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Data Alumni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="filterFormContent">
                    <p>Loading form...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                {{-- Konten form hapus akan di-load via AJAX --}}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            console.log('jQuery loaded:', typeof $ !== 'undefined');
            console.log('Bootstrap loaded:', typeof bootstrap !== 'undefined');

            let table = $('#alumni-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('alumni.list') }}",
                    data: function(d) {
                        d.program_studi = $('#filter_program_studi').val();
                        d.tahun_lulus_start = $('#filter_tahun_lulus_start').val();
                        d.tahun_lulus_end = $('#filter_tahun_lulus_end').val();
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
                        data: 'nim',
                        name: 'nim'
                    },
                    {
                        data: 'program_studi',
                        name: 'program_studi'
                    },
                    {
                        data: 'tahun_lulus_formatted',
                        name: 'tahun_lulus'
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
            $('#btn-tambah').on('click', function() {
                console.log('Tombol Tambah clicked');
                $.get('{{ route('alumni.create') }}', function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Detail
            $('#alumni-table').on('click', '.btn-detail', function() {
                let id = $(this).data('id');
                console.log('Tombol Detail clicked, ID:', id);
                let url = '{{ route('alumni.show_ajax', ':id') }}'.replace(':id', id);
                $.get(url, function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Edit
            $('#alumni-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                console.log('Tombol Edit clicked, ID:', id);
                let url = '{{ route('alumni.edit', ':id') }}'.replace(':id', id);
                $.get(url, function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Hapus
            $('#alumni-table').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                console.log('Tombol Hapus clicked, ID:', id);
                let url = '{{ route('alumni.confirm_ajax', ':id') }}'.replace(':id', id);
                $.get(url, function(res) {
                    $('#deleteModal .modal-content').html(res);
                    $('#deleteModal').modal('show');
                });
            });

            // Tombol Export Excel
            $('#btn-export').on('click', function() {
                let program_studi = $('#filter_program_studi').val() || '';
                let tahun_lulus_start = $('#filter_tahun_lulus_start').val() || '';
                let tahun_lulus_end = $('#filter_tahun_lulus_end').val() || '';
                let url = '{{ route('alumni.export_excel') }}?' + $.param({
                    program_studi: program_studi,
                    tahun_lulus_start: tahun_lulus_start,
                    tahun_lulus_end: tahun_lulus_end
                });
                window.location.href = url;
            });

            // Load form filter saat modal dibuka
            $('#filterModal').on('show.bs.modal', function() {
                console.log('Modal filter opened');
                $.ajax({
                    url: "{{ route('alumni.filter') }}",
                    type: 'GET',
                    success: function(res) {
                        console.log('Filter form loaded:', res);
                        $('#filterFormContent').html(res);
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal memuat form filter! Status: ' + xhr.status
                        });
                    }
                });
            });

            // Submit form filter
            $(document).on('submit', '#filterForm', function(e) {
                e.preventDefault();
                console.log('Filter form submitted');
                let start = $('#filter_tahun_lulus_start').val();
                let end = $('#filter_tahun_lulus_end').val();
                if (start && end && parseInt(start) > parseInt(end)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tahun mulai harus lebih kecil dari tahun akhir!'
                    });
                    return;
                }
                table.ajax.reload();
                $('#filterModal').modal('hide');
                $('.modal-backdrop').remove();
            });

            // Reset filter
            $(document).on('click', '#resetFilter', function() {
                console.log('Reset filter clicked');
                $('#filter_program_studi').val('');
                $('#filter_tahun_lulus_start').val('');
                $('#filter_tahun_lulus_end').val('');
                table.ajax.reload();
                $('#filterModal').modal('hide');
            });
        });
    </script>
@endpush

@extends('layouts.template')
<link rel="stylesheet" href="{{ asset('skydash/template/css/styletambah.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold">Data Alumni</h3>
            <hr>
            <p class="card-description">
                Kelola data alumni dengan mudah untuk mendukung pencatatan lulusan, pelacakan karier, dan evaluasi hasil
                pendidikan. Fitur ini memungkinkan Anda menambahkan, mengedit, dan menghapus data alumni sesuai kebutuhan,
                sehingga mempermudah pengelolaan informasi alumni secara terstruktur dan efisien.
            </p>
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-info d-flex align-items-center gap-1" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i>
                    Tambah Alumni
                </button>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-1 ms-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="mdi mdi-filter fs-5 mr-2"></i>
                    Filter
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table" id="alumni-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Program Studi</th>
                            <th>Tahun Lulus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk Form Create/Edit dan Hapus -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{-- Konten form (create/edit/hapus) akan di‐load via AJAX --}}
            </div>
        </div>
    </div>

    <!-- Modal untuk Filter -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="filterModalLabel">Filter Data Alumni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="filterFormContent">
                    <p>Loading form...</p> <!-- Debugging placeholder -->
                </div>
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
            console.log('jQuery loaded:', typeof $ !== 'undefined'); // Debugging
            console.log('Bootstrap loaded:', typeof bootstrap !== 'undefined'); // Debugging

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
                        data: 'username',
                        name: 'username'
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
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
                console.log('Tombol Tambah clicked'); // Debugging
                $.get('{{ route('alumni.create') }}', function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Edit
            $('#alumni-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                console.log('Tombol Edit clicked, ID:', id); // Debugging
                let url = '{{ route('alumni.edit', ':id') }}'.replace(':id', id);
                $.get(url, function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Hapus
            $('#alumni-table').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                console.log('Tombol Hapus clicked, ID:', id); // Debugging
                let url = '{{ route('alumni.confirm_ajax', ':id') }}'.replace(':id', id);
                $.get(url, function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Load form filter saat modal dibuka
            $('#filterModal').on('show.bs.modal', function() {
                console.log('Modal filter opened'); // Debugging
                $.ajax({
                    url: "{{ route('alumni.filter') }}",
                    type: 'GET',
                    success: function(res) {
                        console.log('Filter form loaded:', res); // Debugging
                        $('#filterFormContent').html(res);
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr); // Debugging
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
                console.log('Filter form submitted'); // Debugging
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
            });

            // Reset filter
            $(document).on('click', '#resetFilter', function() {
                console.log('Reset filter clicked'); // Debugging
                $('#filter_program_studi').val('');
                $('#filter_tahun_lulus_start').val('');
                $('#filter_tahun_lulus_end').val('');
                table.ajax.reload();
                $('#filterModal').modal('hide');
            });
        });
    </script>
@endpush
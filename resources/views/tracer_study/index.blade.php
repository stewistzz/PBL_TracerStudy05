@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold">Tracer Study</h3>
            <hr>
            <p class="card-description">
                Lengkapi semua langkah untuk menyelesaikan tracer study agar hasilnya dapat kami proses dengan baik.
            </p>

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('tracer-study.data-diri') }}" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i>
                    Isi Data Diri
                </a>
            </div>

            <div class="table-responsive">
                <table class="table" id="tracer-study-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Progres Data Diri</th>
                            <th>Progres Data Atasan</th>
                            <th>Progres Kuesioner</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            @if ($progress['kuesioner'])
                <div class="alert alert-success mt-4">
                    Selamat! Anda telah menyelesaikan Tracer Study.
                    <a href="{{ route('tracer-study.success') }}" class="alert-link">Lihat hasil</a>.
                </div>
            @endif
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
            $('#tracer-study-table').DataTable().ajax.reload();
        };

        $(document).ready(function() {
            let table = $('#tracer-study-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tracer-study.list') }}",
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
                        data: 'progress_data_diri',
                        name: 'progress_data_diri',
                        render: function(data) {
                            return data ? '<span class="badge bg-success">Sudah</span>' :
                                '<span class="badge bg-secondary">Belum</span>';
                        }
                    },
                    {
                        data: 'progress_data_atasan',
                        name: 'progress_data_atasan',
                        render: function(data) {
                            return data ? '<span class="badge bg-success">Sudah</span>' :
                                '<span class="badge bg-secondary">Belum</span>';
                        }
                    },
                    {
                        data: 'progress_kuesioner',
                        name: 'progress_kuesioner',
                        render: function(data) {
                            return data ? '<span class="badge bg-success">Sudah</span>' :
                                '<span class="badge bg-secondary">Belum</span>';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            return data ? '<span class="text-success fw-bold">Selesai</span>' :
                                '<span class="text-warning fw-bold">Proses</span>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                responsive: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
                }
            });

            // Contoh event untuk tombol aksi jika ada di kolom action,
            // misal membuka modal edit, hapus, dll bisa kamu tambahkan di sini
        });
    </script>
@endpush

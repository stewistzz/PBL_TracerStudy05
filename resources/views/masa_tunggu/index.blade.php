@extends('layouts.template')

@section('content')
    {{-- Header Card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-clock-outline me-1"></i> Masa Tunggu Alumni
                </h4>
            </div>
            <p class="card-description text-muted">
                Tabel ini menampilkan lama masa tunggu alumni dari waktu kelulusan hingga tanggal pertama bekerja.
            </p>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold" style="color: #2A3143;">
                <i class="mdi mdi-account-multiple-outline me-1"></i> Data Masa Tunggu
            </h3>
            <hr>


            <div class="row">
                <div class="col-6">
                    <p class="card-description">
                        Kelola Alumni untuk kebutuhan pengisian survey tracer study POLINEMA
                    </p>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-end mb-3">
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


            <div class="table-responsive">
                <table class="table" id="masa-tunggu-table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Tahun Lulus</th>
                            <th>Tanggal Pertama Kerja</th>
                            <th>Masa Tunggu (bulan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $alumni)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $alumni['nama'] }}</td>
                                <td>{{ $alumni['nim'] }}</td>
                                <td>{{ $alumni['program_studi'] }}</td>
                                <td>{{ $alumni['tahun_lulus'] }}</td>
                                <td>{{ $alumni['tanggal_pertama_kerja'] ?? '-' }}</td>
                                <td>{{ $alumni['masa_tunggu'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data alumni yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#masa-tunggu-table').DataTable();

        // Load form filter saat modal dibuka
        $('#filterModal').on('show.bs.modal', function () {
            console.log('Modal filter opened');
            $.ajax({
                url: "{{ route('masa_tunggu.filter') }}",
                type: 'GET',
                success: function (res) {
                    console.log('Filter form loaded:', res);
                    $('#filterFormContent').html(res);
                },
                error: function (xhr) {
                    console.error('AJAX Error:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal memuat form filter! Status: ' + xhr.status
                    });
                }
            });
        });

        // Tombol Export Excel
        $('#btn-export').on('click', function () {
            let program_studi = $('#filter_program_studi').val() || '';
            let tahun_lulus_start = $('#filter_tahun_lulus_start').val() || '';
            let tahun_lulus_end = $('#filter_tahun_lulus_end').val() || '';

            let url = '{{ route("masa_tunggu.export") }}?' + $.param({
                program_studi: program_studi,
                tahun_lulus_start: tahun_lulus_start,
                tahun_lulus_end: tahun_lulus_end
            });

            window.location.href = url;
        });
    });
</script>
@endpush

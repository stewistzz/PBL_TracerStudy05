@extends('layouts.template')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kepuasan.css') }}">

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="header d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-chart-line me-2"></i>Dashboard Kepuasan Pengguna</h2>
            <p>Ringkasan tingkat kepuasan pengguna berdasarkan jenis kemampuan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('kepuasan.export-excel') }}" class="btn btn-success btn-export">
                <i class="fas fa-file-excel me-2"></i>Export ke Excel
            </a>
        </div>
    </div>

    <!-- Responden Summary Card -->
    <div class="responden-card mb-4">
        <div class="responden-icon">
            <i class="fas fa-users fa-2x"></i>
        </div>
        <div class="text-content">
            <h4 class="mb-1">Total Responden</h4>
            <h2 class="fw-bold mb-0" id="card-responden">0</h2>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 g-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon sangat-baik"><i class="fas fa-star"></i></div>
                <h3 class="text-dark mb-1" id="card-sangat-baik">0%</h3>
                <p class="text-muted mb-0">Sangat Baik</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon baik"><i class="fas fa-thumbs-up"></i></div>
                <h3 class="text-dark mb-1" id="card-baik">0%</h3>
                <p class="text-muted mb-0">Baik</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon cukup"><i class="fas fa-minus-circle"></i></div>
                <h3 class="text-dark mb-1" id="card-cukup">0%</h3>
                <p class="text-muted mb-0">Cukup</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card text-center">
                <div class="stats-icon kurang"><i class="fas fa-times-circle"></i></div>
                <h3 class="text-dark mb-1" id="card-kurang">0%</h3>
                <p class="text-muted mb-0">Kurang</p>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table position-relative mb-4">
        <div class="loading-overlay" id="loading-overlay">
            <div class="text-center">
                <div class="spinner mb-3"></div>
                <p class="text-muted">Memuat data...</p>
            </div>
        </div>

        <table id="tabelKemampuan" class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="40%" class="jenis-kemampuan">Jenis Kemampuan</th>
                    <th width="12.5%">Sangat Baik</th>
                    <th width="12.5%">Baik</th>
                    <th width="12.5%">Cukup</th>
                    <th width="12.5%">Kurang</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Rata-rata Total</strong></td>
                    <td id="footer-sangat-baik" class="fw-bold">-</td>
                    <td id="footer-baik" class="fw-bold">-</td>
                    <td id="footer-cukup" class="fw-bold">-</td>
                    <td id="footer-kurang" class="fw-bold">-</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Jawaban Teks Section -->
    <div class="row g-4">
        <!-- K08 - Kompetensi yang Dibutuhkan tapi Belum Dipenuhi -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list-ul me-2"></i>Kompetensi yang Dibutuhkan tapi Belum Dipenuhi</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="k08-responses">
                        <div class="text-center text-muted py-3">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Memuat jawaban...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- K09 - Saran untuk Kurikulum Program Studi -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Saran untuk Kurikulum Program Studi</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div id="k09-responses">
                        <div class="text-center text-muted py-3">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Memuat jawaban...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    $(document).ready(function() {
        $('#loading-overlay').show();

        const table = $('#tabelKemampuan').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ url("/kepuasan/list") }}',
                dataSrc: function(json) {
                    console.log('Response received:', json); // Debug log
                    setTimeout(() => $('#loading-overlay').fadeOut(), 500);
                    updateFooterAndCards(json.footer);
                    displayTextResponses(json.text_responses);
                    return json.data;
                },
                error: function() {
                    $('#loading-overlay').fadeOut();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '10%' },
                { data: 'jenis', name: 'jenis', className: 'text-start jenis-kemampuan', width: '40%' },
                { data: 'sangat_baik', name: 'sangat_baik', className: 'text-center', width: '12.5%', render: d => d + '%' },
                { data: 'baik', name: 'baik', className: 'text-center', width: '12.5%', render: d => d + '%' },
                { data: 'cukup', name: 'cukup', className: 'text-center', width: '12.5%', render: d => d + '%' },
                { data: 'kurang', name: 'kurang', className: 'text-center', width: '12.5%', render: d => d + '%' }
            ],
            columnDefs: [
                { targets: [0, 2, 3, 4, 5], searchable: false, orderable: false },
                { targets: 1, searchable: false, orderable: false, className: 'jenis-kemampuan' }
            ],
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            language: {
                emptyTable: "Tidak ada data tersedia",
                loadingRecords: "Memuat..."
            }
        });

        function updateFooterAndCards(footer) {
            $('#footer-sangat-baik').text(footer.sangat_baik + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#footer-baik').text(footer.baik + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#footer-cukup').text(footer.cukup + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#footer-kurang').text(footer.kurang + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#card-sangat-baik').text(footer.sangat_baik + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#card-baik').text(footer.baik + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#card-cukup').text(footer.cukup + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#card-kurang').text(footer.kurang + '%').css('opacity', 0).animate({ opacity: 1 }, 600);
            $('#card-responden').text(footer.responden).css('opacity', 0).animate({ opacity: 1 }, 600);
        }

        function displayTextResponses(textResponses) {
            console.log('Text responses received:', textResponses); // Debug log
            
            // Display K08 responses
            const k08Container = $('#k08-responses');
            if (textResponses && textResponses.K08 && textResponses.K08.length > 0) {
                let k08Html = '';
                textResponses.K08.forEach((response, index) => {
                    k08Html += `
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <p class="mb-1">${response.jawaban}</p>
                                </div>
                                <small class="text-muted ms-2">Responden #${response.pengguna_id}</small>
                            </div>
                        </div>
                    `;
                });
                k08Container.html(k08Html);
            } else {
                k08Container.html('<div class="text-center text-muted py-3">Tidak ada jawaban tersedia</div>');
            }

            // Display K09 responses
            const k09Container = $('#k09-responses');
            if (textResponses && textResponses.K09 && textResponses.K09.length > 0) {
                let k09Html = '';
                textResponses.K09.forEach((response, index) => {
                    k09Html += `
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <p class="mb-1">${response.jawaban}</p>
                                </div>
                                <small class="text-muted ms-2">Responden #${response.pengguna_id}</small>
                            </div>
                        </div>
                    `;
                });
                k09Container.html(k09Html);
            } else {
                k09Container.html('<div class="text-center text-muted py-3">Tidak ada jawaban tersedia</div>');
            }
        }
    });
</script>
@endsection
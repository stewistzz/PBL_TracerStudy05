@extends('layouts.template')

@section('content')
    <div class="card shadow-sm border-0 mb-4" style="position: relative; z-index: 0;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-database-plus me-1"></i> Manajemen Data Jawaban Alumni
                </h4>
            </div>
            <p class="card-description text-muted">Tabel ini menampilkan daftar jawaban alumni terkait Tracer Study.</p>
        </div>
    </div>

    <div class="card shadow-sm border-left-primary mb-4" style="position: relative; z-index: 0;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-account-tie me-1"></i> Data Jawaban Alumni
                </h5>
                <div class="d-flex">
                    <button type="button" style="background-color: #5BAEB7;" class="btn btn-sm d-flex align-items-center gap-2 text-white mr-2" id="filterButton" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="mdi mdi-filter"></i> Filter
                    </button>
                    <a href="{{ route('jawaban_alumni.export_excel') }}" id="exportExcel" style="background-color: #5BAEB7;" class="btn btn-sm d-flex align-items-center gap-2 ms-2 text-white">
                        <i class="mdi mdi-file-excel"></i> Export Excel
                    </a>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="jawaban-alumni-table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th>No</th>
                            <th>Alumni</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk Filter -->
    <div id="filterModal" class="modal fade" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- Modal untuk Konfirmasi Hapus -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" style="z-index: 1050;"></div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        let currentFilter = {};

        $(document).ready(function() {
            let table = $('#jawaban-alumni-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('jawaban_alumni.list') }}",
                    data: function(d) {
                        d.pertanyaan_id = $('#filterModal #pertanyaan_id').val() || currentFilter.pertanyaan_id || '';
                        d.alumni = $('#filterModal #alumni').val() || currentFilter.alumni || '';
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1; // Penomoran dimulai dari 1
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'alumni', name: 'alumni' },
                    { data: 'pertanyaan', name: 'pertanyaan' },
                    { data: 'jawaban', name: 'jawaban' },
                    { data: 'tanggal', name: 'tanggal' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Tombol Hapus
            $('#jawaban-alumni-table').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                let url = '{{ route('jawaban_alumni.confirm_ajax', ':id') }}'.replace(':id', id);
                modalAction(url);
            });

            // Handle form submission in delete modal via AJAX
            $(document).on('submit', '#myModal form', function(e) {
                e.preventDefault(); // Prevent default form submission

                let form = $(this);
                let url = form.attr('action');
                let data = form.serialize();

                $.ajax({
                    url: url,
                    type: 'POST', // Laravel uses POST with _method=DELETE for DELETE requests
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide'); // Close modal
                            $('.modal-backdrop').remove(); // Remove backdrop
                            $('body').removeClass('modal-open'); // Remove modal-open class
                            table.ajax.reload(); // Reload DataTable
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message || 'Data berhasil dihapus!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message || 'Gagal menghapus data',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error deleting data:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Load Filter Modal
            $('#filterModal').on('show.bs.modal', function () {
                // Clear previous modal content to avoid conflicts
                $('#filterModal .modal-content').html('');
                $(this).find('.modal-content').load('{{ route('jawaban_alumni.filter') }}', function() {
                    $.ajax({
                        url: '{{ route('jawaban_alumni.getPertanyaan') }}',
                        method: 'GET',
                        success: function(response) {
                            let select = $('#filterModal #pertanyaan_id');
                            select.empty().append('<option value="">Semua Pertanyaan</option>');
                            $.each(response, function(index, pertanyaan) {
                                select.append('<option value="' + pertanyaan.pertanyaan_id + '">' + pertanyaan.isi_pertanyaan + '</option>');
                            });
                            select.val(currentFilter.pertanyaan_id || '');
                        },
                        error: function(xhr) {
                            console.error('Error loading pertanyaan:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Gagal memuat data pertanyaan.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                    $('#filterModal #alumni').val(currentFilter.alumni || '');
                });
            });

            // Submit Filter
            $(document).on('submit', '#filterForm', function(e) {
                e.preventDefault();
                currentFilter.pertanyaan_id = $('#filterModal #pertanyaan_id').val();
                currentFilter.alumni = $('#filterModal #alumni').val();
                table.ajax.reload();
                $('#filterModal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                // Restore focus to filter button
                $('#filterButton').focus();
            });

            // Reset Filter
            $(document).on('click', '#resetFilter', function() {
                currentFilter = {};
                $('#filterModal #pertanyaan_id').val('');
                $('#filterModal #alumni').val('');
                table.ajax.reload();
                $('#filterModal').modal('hide');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                // Restore focus to filter button
                $('#filterButton').focus();
            });

            // Handle modal hidden event to ensure backdrop is removed
            $('#filterModal').on('hidden.bs.modal', function () {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                // Ensure modal is fully reset
                $('#filterModal').modal('dispose').modal({ backdrop: true, keyboard: true });
                // Restore focus to filter button
                $('#filterButton').focus();
            });

            // Manual trigger for filter button to ensure responsiveness
            $('#filterButton').on('click', function() {
                $('#filterModal').modal('show');
            });

            // Export Excel
            $('#exportExcel').on('click', function(e) {
                e.preventDefault();
                let url = '{{ route('jawaban_alumni.export_excel') }}';
                if (Object.keys(currentFilter).length > 0) {
                    url += '?' + $.param(currentFilter);
                }
                window.location.href = url;
            });
        });
    </script>
@endpush
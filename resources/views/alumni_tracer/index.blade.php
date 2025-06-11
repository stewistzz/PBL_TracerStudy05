@extends('layouts.template')

@section('content')
    {{-- card --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-school me-1"></i> Data Tracer Study POLINEMA
                </h4>
            </div>
            <p class="card-description text-muted">
                Lihat data tracer study POLINEMA untuk menampilkan detail dari tracer study dan data alumni. Anda memiliki
                peran untuk mengirim <strong>Token Link</strong> untuk pengisian E-mail Atasan
            </p>
        </div>
    </div>
    {{-- end card --}}

    {{-- Modal untuk Filter --}}
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filterForm">
                        <div class="form-group">
                            <label for="filter_program_studi">Program Studi</label>
                            <select class="form-control" id="filter_program_studi" name="program_studi">
                                <option value="">Semua Program Studi</option>
                                @foreach (App\Models\AlumniModel::distinct()->pluck('program_studi') as $prodi)
                                    <option value="{{ $prodi }}">{{ $prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filter_tahun_lulus_start">Tahun Lulus (Dari)</label>
                            <input type="number" class="form-control" id="filter_tahun_lulus_start"
                                name="tahun_lulus_start" placeholder="Contoh: 2018" min="1900" max="2100">
                        </div>
                        <div class="form-group">
                            <label for="filter_tahun_lulus_end">Tahun Lulus (Sampai)</label>
                            <input type="number" class="form-control" id="filter_tahun_lulus_end" name="tahun_lulus_end"
                                placeholder="Contoh: 2025" min="1900" max="2100">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="resetFilterBtn">Reset</button>
                    <button type="button" class="btn btn-primary" id="applyFilterBtn">Terapkan</button>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        {{-- Card: Tracer Study Data --}}
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Tracer Study</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="card-description text-muted">Daftar tracer alumni yang telah mengisi</p>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end mb-3">
                                {{-- Tombol Filter --}}
                                <button type="button"
                                    class="btn btn-sm d-flex align-items-center gap-1 ms-2 text-white mr-2 btn-filter"
                                    style="background-color: #5BAEB7;" data-table-id="tracer-table"
                                    data-export-link-id="export-rekap-tracer-link"
                                    data-export-route="{{ route('alumni_tracer.export_rekap_tracer') }}">
                                    <i class="mdi mdi-filter fs-5 mr-2"></i>
                                    Filter
                                </button>

                                {{-- Tombol Export --}}
                                <a href="{{ route('alumni_tracer.export_rekap_tracer') }}"
                                    class="btn btn-sm d-flex align-items-center gap-1 ms-2 text-white"
                                    style="background-color: #5BAEB7;" id="export-rekap-tracer-link">
                                    <i class="mdi mdi-file-excel fs-5 mr-2"></i>
                                    Export Excel
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tracer-table">
                            <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                                <tr>
                                    <th>No</th>
                                    <th>Alumni</th>
                                    <th>Instansi</th>
                                    <th>Kategori Profesi</th>
                                    <th>Profesi</th>
                                    <th>Tanggal Pengisian</th>
                                    <th>Tgl Pertama Kerja</th>
                                    <th>Tgl Mulai Instansi</th>
                                    <th>Nama Atasan</th>
                                    <th>Jabatan Atasan</th>
                                    <th>No HP Atasan</th>
                                    <th>Email Atasan</th>
                                    <th>Masa Tunggu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Belum Mengisi Tracer --}}
        <div class="col-12 grid-margin stretch-card mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Alumni Belum Mengisi Tracer Study</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="card-description text-muted">Berikut ini adalah alumni yang belum mengisi tracer study
                                POLINEMA</p>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-end mb-3">
                                {{-- Tombol Filter --}}
                                <button type="button"
                                    class="btn btn-sm d-flex align-items-center gap-1 ms-2 text-white mr-2 btn-filter"
                                    style="background-color: #5BAEB7;" data-table-id="tracer-table-belum-isi"
                                    data-export-link-id="btn-export"
                                    data-export-route="{{ route('alumni_tracer.export_belum_isi') }}">
                                    <i class="mdi mdi-filter fs-5 mr-2"></i>
                                    Filter
                                </button>

                                {{-- Tombol Export --}}
                                <a href="{{ route('alumni_tracer.export_belum_isi') }}"
                                    class="btn btn-sm d-flex align-items-center gap-1 ms-2 text-white"
                                    style="background-color: #5BAEB7;" id="btn-export">
                                    <i class="mdi mdi-file-excel fs-5 mr-2"></i>
                                    Export Excel
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tracer-table-belum-isi">
                            <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                                <tr>
                                    <th>No</th>
                                    <th>Alumni</th>
                                    <th>NIM</th>
                                    <th>Program Studi</th>
                                    <th>No HP</th>
                                    <th>Email</th>
                                    <th>Tahun Lulus</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('click', '.btn-delete', function() {
            const tracerId = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/alumni-tracer/' + tracerId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire('Berhasil!', res.message, 'success');
                            $('#tracer-table').DataTable().ajax.reload(null, false);
                        },
                        error: function(err) {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.',
                                'error');
                        }
                    });
                }
            });
        });
    </script>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script>
        (function() {
            emailjs.init("WNsnsXwxIbnPiaXE6"); // Ganti dengan PUBLIC KEY dari EmailJS milikmu
        })();

        function sendSurveyEmail(data) {
            console.log("EMAIL DATA YANG DIKIRIM:", data); // Debug

            if (!data.to_email || data.to_email.trim() === '') {
                Swal.fire('Gagal', '❌ Alamat email atasan kosong.', 'error');
                return;
            }

            emailjs.send("service_h3n3nt9", "template_t70mwnb", {
                to_name: data.to_name,
                to_email: data.to_email,
                survey_link: data.survey_link
            }).then(function(response) {
                Swal.fire('Berhasil', '✅ Email berhasil dikirim ke ' + data.to_email, 'success');
                $('#tracer-table').DataTable().ajax.reload(null, false);
            }, function(error) {
                Swal.fire('Gagal', '❌ Gagal mengirim email: ' + JSON.stringify(error), 'error');
            });
        }

        $(document).ready(function() {
            // Inisialisasi DataTable untuk tabel yang sudah mengisi
            var table = $('#tracer-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('alumni_tracer.list') }}",
                    data: function(d) {
                        d.program_studi = $('#tracer-table').data('filter-prodi');
                        d.tahun_lulus_start = $('#tracer-table').data('filter-tahun-start');
                        d.tahun_lulus_end = $('#tracer-table').data('filter-tahun-end');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'alumni',
                        name: 'alumni.nama'
                    },
                    {
                        data: 'instansi',
                        name: 'instansi.nama_instansi'
                    },
                    {
                        data: 'kategori_profesi',
                        name: 'kategoriProfesi.nama_kategori'
                    },
                    {
                        data: 'profesi',
                        name: 'profesi.nama_profesi'
                    },
                    {
                        data: 'tanggal_pengisian',
                        name: 'tanggal_pengisian'
                    },
                    {
                        data: 'tanggal_pertama_kerja',
                        name: 'tanggal_pertama_kerja'
                    },
                    {
                        data: 'tanggal_mulai_kerja_instansi_saat_ini',
                        name: 'tanggal_mulai_kerja_instansi_saat_ini'
                    },
                    {
                        data: 'nama_atasan',
                        name: 'nama_atasan_langsung'
                    },
                    {
                        data: 'jabatan_atasan',
                        name: 'jabatan_atasan_langsung'
                    },
                    {
                        data: 'no_hp_atasan',
                        name: 'no_hp_atasan_langsung'
                    },
                    {
                        data: 'email_atasan',
                        name: 'email_atasan_langsung'
                    },
                    {
                        data: 'masa_tunggu',
                        name: 'masa_tunggu'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Event tombol kirim email
            $('#tracer-table').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var button = $(this);

                Swal.fire({
                    title: 'Kirim Token?',
                    text: "Kamu akan mengirim token survei ke email atasan. Lanjutkan?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kirim sekarang!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('alumni_tracer.kirim_token', ':id') }}'.replace(
                                ':id', id),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.email_data) {
                                    if (!response.email_data.to_email || response
                                        .email_data.to_email.trim() === '') {
                                        Swal.fire('Gagal',
                                            '❌ Email atasan tidak tersedia. Harap lengkapi data terlebih dahulu.',
                                            'error');
                                        return;
                                    }

                                    sendSurveyEmail(response.email_data);
                                    button.removeClass('btn-warning').addClass(
                                        'btn-success').text('Terkirim');
                                } else {
                                    Swal.fire('Gagal', response.message ||
                                        'Gagal membuat token.', 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error', xhr.responseJSON?.message ||
                                    '❌ Terjadi kesalahan saat mengirim token.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Inisialisasi DataTable untuk tabel yang belum mengisi
            var tableBelumIsi = $('#tracer-table-belum-isi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('alumni_tracer.belum_isi') }}",
                    data: function(d) {
                        d.program_studi = $('#tracer-table-belum-isi').data('filter-prodi');
                        d.tahun_lulus_start = $('#tracer-table-belum-isi').data('filter-tahun-start');
                        d.tahun_lulus_end = $('#tracer-table-belum-isi').data('filter-tahun-end');
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
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'tahun_lulus',
                        name: 'tahun_lulus'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // --- Logika Filter ---
            let currentFilterTargetTable = null;
            let currentExportLinkId = null;
            let currentExportRoute = null;

            // Ambil data filter (prodi) via AJAX
            $.get("{{ route('alumni_tracer.filter_ajax') }}", function(data) {
                let prodiOptions = '<option value="">Semua Program Studi</option>';
                data.program_studi.forEach(function(prodi) {
                    prodiOptions += `<option value="${prodi}">${prodi}</option>`;
                });
                $('#filter_program_studi').html(prodiOptions);
            });


            $(document).on('click', '.btn-filter', function() {
                currentFilterTargetTable = '#' + $(this).data('table-id');
                currentExportLinkId = '#' + $(this).data('export-link-id');
                currentExportRoute = $(this).data('export-route');

                // Set nilai filter di modal sesuai dengan data yang tersimpan
                $('#filter_program_studi').val($(currentFilterTargetTable).data('filter-prodi') || '');
                $('#filter_tahun_lulus_start').val($(currentFilterTargetTable).data('filter-tahun-start') ||
                    '');
                $('#filter_tahun_lulus_end').val($(currentFilterTargetTable).data('filter-tahun-end') ||
                    '');

                $('#filterModal').modal('show');
            });

            function updateExportLink(linkId, baseRoute, prodi, tahunStart, tahunEnd) {
                const params = $.param({
                    program_studi: prodi,
                    tahun_lulus_start: tahunStart,
                    tahun_lulus_end: tahunEnd
                });
                $(linkId).attr('href', baseRoute + '?' + params);
            }

            $('#applyFilterBtn').on('click', function() {
                const prodi = $('#filter_program_studi').val();
                const tahunStart = $('#filter_tahun_lulus_start').val();
                const tahunEnd = $('#filter_tahun_lulus_end').val();

                if (tahunStart && tahunEnd && parseInt(tahunStart) > parseInt(tahunEnd)) {
                    Swal.fire('Gagal', 'Tahun mulai harus lebih kecil atau sama dengan tahun akhir.',
                        'error');
                    return;
                }

                // Simpan state filter di elemen tabel
                $(currentFilterTargetTable).data('filter-prodi', prodi);
                $(currentFilterTargetTable).data('filter-tahun-start', tahunStart);
                $(currentFilterTargetTable).data('filter-tahun-end', tahunEnd);

                // Reload tabel dan perbarui link export
                $(currentFilterTargetTable).DataTable().ajax.reload();
                updateExportLink(currentExportLinkId, currentExportRoute, prodi, tahunStart, tahunEnd);
                $('#filterModal').modal('hide');
            });

            $('#resetFilterBtn').on('click', function() {
                $('#filterForm')[0].reset();

                // Hapus state filter dari elemen tabel
                $(currentFilterTargetTable).data('filter-prodi', '');
                $(currentFilterTargetTable).data('filter-tahun-start', '');
                $(currentFilterTargetTable).data('filter-tahun-end', '');

                // Reload tabel dan reset link export
                $(currentFilterTargetTable).DataTable().ajax.reload();
                updateExportLink(currentExportLinkId, currentExportRoute, '', '', '');
                $('#filterModal').modal('hide');
            });

        });
    </script>
@endpush

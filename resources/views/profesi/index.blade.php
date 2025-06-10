@extends('layouts.template')

@section('content')
{{-- header --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-account-tie-outline"></i> Profesi Alumni
                </h4>
            </div>
            <hr>
            <p class="card-description text-muted">
                Data berikut ini menampilkan sebaran grafik dan daftar profesi alumni.
            </p>
        </div>
    </div>
    <!-- Card Pie Chart Profesi -->
    <div class="row">
        <!-- Card Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card rounded-4">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold mb-3">Sebaran Profesi Alumni</h4>
                    <canvas id="profesiChart" width="240" height="240"></canvas>
                </div>
            </div>
        </div>

        <!-- Card Detail -->
        <div class="col-lg-8 mb-4">
            <div class="card rounded-4 shadow-sm h-100 p-4">
                <h2 class="fw-bold mb-3 text-dark">
                    <b>Detail Sebaran Profesi Alumni</b><br>
                </h2>
                <h2><b style="color: rgb(30, 161, 201);">Politeknik Negeri Malang</b></h2>


                <div class="my-2">
                    <h1 class="display-3 fw-black text-dark">{{ $jumlah_profesi }}</h1>
                    <h5>Total Profesi</h5>
                </div>

                <p class="text-muted fs-10" style="text-align: justify;">
                    Grafik ini menampilkan data sebaran profesi alumni
                    <span class="fw-semibold text-dark">Politeknik Negeri Malang</span>
                    berdasarkan hasil <i>tracer study</i> selama 4 tahun terakhir.
                    Informasi ini memberikan gambaran tren karier lulusan, bidang pekerjaan
                    yang paling diminati, serta menjadi acuan dalam evaluasi dan pengembangan
                    program studi untuk meningkatkan relevansi pendidikan dengan kebutuhan industri.
                </p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="background-color: #FFFFFF;">
        <div class="card-body">
            <h5 class="card-title" style="color: #2A3143;">Tabel Data Profesi</h5>
            <hr>
            <div class="row">
                <div class="col-9">
                    <p class="card-description">
                        Tabel ini menampilkan isi data dari berbagai macam profesi terkait dalam kebutuhan pengumpulan informasi mengenai Tracer Study.
                    </p>
                    {{-- <button class="btn btn-primary mb-3" id="btn-tambah">Tambah Profesi</button> --}}
                </div>
                <div class="col-3">
                    <div class="d-flex justify-content-end mb-3">
                        <button onclick="modalAction('{{ url('/profesi/create_ajax') }}')" style="background-color: #5BAEB7;"
                            class="btn btn-sm d-flex align-items-center gap-2 text-white" id="btn-tambah">
                            <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="profesi-table">
                    <thead class="thead-dark" style="background-color: #1E80C1; color: #FFFFFF;">
                        <tr>
                            <th>No</th>
                            <th>Nama Profesi</th>
                            <th>Kategori ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            let table = $('#profesi-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('profesi.list') }}", // pastikan route ini sesuai
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_profesi',
                        name: 'nama_profesi'
                    },
                    {
                        data: 'kategori_id',
                        name: 'kategori_id'
                    }, // tampilkan kategori_id
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#kategori_id').on('change', function() {
                $('#profesi-table').DataTable().ajax.reload();
            });
        });
    </script>

    {{-- script untuk chart --}}
    {{-- <script>
        var profesiLabels = {!! json_encode($data->pluck('nama_profesi')) !!};
        var profesiData = {!! json_encode($data->pluck('total')) !!};

        var profesiChartData = {
            labels: profesiLabels,
            datasets: [{
                data: profesiData,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#C9CBCF', '#FF5E5E',
                    '#5EF0D9', '#A5A5A5', '#8ED081', '#C17CCF',
                    '#F5A623', '#34C759', '#C4C4C4'
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        };

        var profesiChartOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };

        $(document).ready(function() {
            if ($("#profesiChart").length) {
                var profesiCanvas = $("#profesiChart").get(0).getContext("2d");
                new Chart(profesiCanvas, {
                    type: 'pie',
                    data: profesiChartData,
                    options: profesiChartOptions
                });
            }
        });
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const profesiCtx = document.getElementById('profesiChart').getContext('2d');

        const profesiChart = new Chart(profesiCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($data->pluck('nama_profesi')) !!},
                datasets: [{
                    label: 'Sebaran Profesi Alumni',
                    data: {!! json_encode($data->pluck('total')) !!},
                    backgroundColor: [
                        '#004E7C', // Navy Blue
                        '#0077B6', // Blue Ocean
                        '#0096C7', // Sky Blue
                        '#00B4D8', // Light Blue
                        '#48CAE4', // Soft Cyan
                        '#90E0EF', // Pale Blue
                        '#CAF0F8', // Very Pale Blue
                        '#023E8A', // Dark Blue
                        '#007F5F', // Deep Sea Green
                        '#00B894', // Aqua Green
                        '#55EFC4', // Mint Green
                        '#1B262C', // Dark Slate
                        '#0F4C75', // Strong Blue
                        '#3282B8', // Medium Blue
                        '#66BFBF', // Light Sea Green
                    ],

                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value} orang`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush

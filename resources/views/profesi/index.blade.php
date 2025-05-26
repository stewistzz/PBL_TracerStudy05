@extends('layouts.template')

@section('content')
    <!-- Card Pie Chart Profesi -->
    <div class="row">
        <div class="col-lg-4 grid-margin grid-margin-lg-0 stretch-card mb-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-bold">Sebaran Profesi Alumni</h4>
                    <div class="doughnutjs-wrapper d-flex justify-content-center">
                        <canvas id="profesiChart" style="display: block; height: 240px; width: 240px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 grid-margin grid-margin-lg-0 stretch-card m-auto">
            <div>
                <h3 class="">Detail sebaran <b>profesi</b> alumni Politeknik Negeri Malang</h3>
                <div class="mt-4 mb-4">

                    <h1>{{ $jumlah_profesi }}</h1>
                    <p>Total Profesi</p>
                </div>
                <p>Grafik menunjukkan sebaran data profesi mahasiswa Politeknik Negeri Malang berdasarkan data tracer alumni 4 tahun terakhir.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Profesi</h4>
            <p class="card-description">
                Kelola data profesi dan kategori profesi
            </p>
            {{-- <button class="btn btn-primary mb-3" id="btn-tambah">Tambah Profesi</button> --}}

            <button onclick="modalAction('{{ url('/profesi/create_ajax') }}')" class="btn btn-primary mb-3">Tambah
                Data</button>


            <div class="table-responsive">
                <table class="table" id="profesi-table">
                    <thead>
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
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#C9CBCF', '#FF5E5E',
                    '#5EF0D9', '#A5A5A5', '#8ED081', '#C17CCF',
                    '#F5A623', '#34C759', '#C4C4C4'
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

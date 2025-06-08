@extends('layouts.template')
@section('content')
    <div class="row">
        <!-- Card Pie Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card rounded-4">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold mb-4">Sebaran Kesesuaian Alumni</h4>
                    <div class="doughnutjs-wrapper d-flex justify-content-center">
                        <canvas id="pieChart" width="240" height="240"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Detail -->
        <div class="col-lg-8 mb-4">
            <div class="card rounded-4 shadow-sm h-100 p-4">
                <h2 class="fw-bold mb-3 text-dark">
                    <b>Detail Kesesuaian Alumni</b><br>
                </h2>
                <h2><b style="color: rgb(30, 161, 201);">Politeknik Negeri Malang</b></h2>

                <div class="my-4">
                    <h1 class="display-3 fw-black text-dark">{{ $data->sum('total_alumni') }}</h1>
                    <h5>Total Alumni</h5>
                </div>

                <p class="text-muted fs-6" style="text-align: justify;">
                    Grafik menunjukkan perbandingan alumni Infokom (sesuai) dengan alumni Non-Infokom (tidak sesuai)
                    berdasarkan data tracer study alumni selama beberapa tahun terakhir.
                    Informasi ini membantu memantau tingkat relevansi lulusan dengan bidang studi serta
                    menjadi acuan evaluasi pengembangan kurikulum dan peningkatan kualitas pendidikan.
                </p>
            </div>
        </div>
    </div>


    <!-- Tabel Data -->
    <div class="col-lg-12 grid-margin stretch-card mt-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                {{-- <h4 class="card-title text-dark">
                    <i class="mdi mdi-city-multiple text-primary me-2"></i>
                    Sebaran Lingkup Tempat Kerja dan Kesesuaian Profesi Dengan Infokom
                </h4> --}}
                <h5 class="card-title" style="color: #2A3143;"><i class="mdi mdi-city me-1"></i> Data Pertanyaan untuk
                Alumni</h5>
            <hr>
                <hr>
                <p class="card-description">
                    Data tracer alumni berdasarkan tahun lulus dan profesi
                </p>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark bg-primary text-white">
                            <tr>
                                <th rowspan="2" class="align-middle">Tahun Lulus</th>
                                <th rowspan="2" class="align-middle">Jumlah Lulusan</th>
                                <th rowspan="2" class="align-middle">Lulusan Terlacak</th>
                                <th rowspan="2" class="align-middle">Profesi Infokom</th>
                                <th rowspan="2" class="align-middle">Profesi Non-Infokom</th>
                                <th colspan="3">Lingkup Tempat Kerja</th>
                            </tr>
                            <tr class="bg-info text-white">
                                <th><i class="mdi mdi-earth me-2"></i>Internasional</th>
                                <th><i class="mdi mdi-city me-2"></i>Nasional</th>
                                <th><i class="mdi mdi-briefcase me-2"></i>Wirausaha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $row)
                                <tr>
                                    <td><span class="badge bg-info">{{ $row->tahun_lulus }}</span></td>
                                    <td>{{ $row->total_alumni }}</td>
                                    <td>{{ $row->alumni_isi_tracer }}</td>
                                    <td><span class="badge bg-success">{{ $row->infokom }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $row->non_infokom }}</span></td>
                                    <td>{{ $row->internasional }}</td>
                                    <td>{{ $row->nasional }}</td>
                                    <td>{{ $row->wirausaha }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Data tidak ditemukan</td>
                                </tr>
                            @endforelse

                            @if ($data->count() > 0)
                                <tr class="table-primary fw-bold">
                                    <td>Jumlah</td>
                                    <td>{{ $data->sum('total_alumni') }}</td>
                                    <td>{{ $data->sum('alumni_isi_tracer') }}</td>
                                    <td>{{ $data->sum('infokom') }}</td>
                                    <td>{{ $data->sum('non_infokom') }}</td>
                                    <td>{{ $data->sum('internasional') }}</td>
                                    <td>{{ $data->sum('nasional') }}</td>
                                    <td>{{ $data->sum('wirausaha') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../../public/skydash/template/pages/charts/chartjs.html"></script>
    <script>
        var doughnutPieData = {
            labels: ['Sesuai Infokom', 'Tidak Sesuai Infokom'],
            datasets: [{
                data: [
                    {{ $data->sum('infokom') }},
                    {{ $data->sum('non_infokom') }}
                ],
                backgroundColor: [
                    'rgba(30, 161, 201, 1)', // Biru ocean solid (Sesuai)
                    'rgba(220, 53, 69, 1)' // Merah solid (Tidak Sesuai)
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        };

        var doughnutPieOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        };

        $(document).ready(function() {
            if ($("#pieChart").length) {
                var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: doughnutPieData,
                    options: doughnutPieOptions
                });
            }
        });
    </script>
@endpush

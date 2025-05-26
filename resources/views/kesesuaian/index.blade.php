@extends('layouts.template')
@section('content')
    <div class="row">
        <!-- Card Pie Chart -->
        <div class="col-lg-4 grid-margin grid-margin-lg-0 stretch-card">
            <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Pie chart</h4>
                    <div class="doughnutjs-wrapper d-flex justify-content-center">
                      <canvas id="pieChart" style="display: block; box-sizing: border-box; height: 220px; width: 220px;" width="220" height="220"></canvas>

                    </div>
                  </div>
            </div>
        </div>

        <!-- Deskripsi / Detail -->
        <div class="col-lg-8 d-flex align-items-center">
            <div>
                <h3>Detail sebaran <b>kesesuaian</b> alumni Politeknik Negeri Malang</h3>
                <div class="mt-3 mb-3">

                    <h1>{{ $data->sum('total_alumni') }}</h1>
                    <p>Total Alumni</p>
                </div>
                <p>Grafik menunjukkan perbandingan alumni Infokom (sesuai) dengan alumni Non-Infokom (tidak sesuai)
                    berdasarkan data tracer alumni.</p>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="col-lg-12 grid-margin stretch-card mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sebaran Lingkup Tempat Kerja dan Kesesuaian Profesi Dengan Infokom</h4>
                    <p class="card-description">
                        <code>Data tracer alumni berdasarkan tahun lulus dan profesi</code>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="2" class="align-middle">Tahun Lulus</th>
                                    <th rowspan="2" class="align-middle">Jumlah Lulusan</th>
                                    <th rowspan="2" class="align-middle">Lulusan Terlacak</th>
                                    <th rowspan="2" class="align-middle">Profesi Infokom</th>
                                    <th rowspan="2" class="align-middle">Profesi Non-Infokom</th>
                                    <th colspan="3">Lingkup Tempat Kerja</th>
                                </tr>
                                <tr class="bg-primary text-light">
                                    <th>Internasional</th>
                                    <th>Nasional</th>
                                    <th>Wirausaha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td><label class="badge badge-info">{{ $row->tahun_lulus }}</label></td>
                                        <td>{{ $row->total_alumni }}</td>
                                        <td>{{ $row->alumni_isi_tracer }}</td>
                                        <td><label class="badge badge-success">{{ $row->infokom }}</label></td>
                                        <td><label class="badge badge-secondary">{{ $row->non_infokom }}</label></td>
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
                                    <tr class="table-primary font-weight-bold">
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
    </div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../../../public/skydash/template/pages/charts/chartjs.html"></script>
{{-- <script>
    var doughnutPieData = {
        labels: ['Sesuai Infokom', 'Tidak Sesuai Infokom'],
        datasets: [{
            data: [
                {{ $data->sum('infokom') }},
                {{ $data->sum('non_infokom') }}
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 99, 132, 0.5)'
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
        }
    };

    $(document).ready(function () {
        if ($("#pieChart").length) {
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: doughnutPieData,
                options: doughnutPieOptions
            });
        }
    });
</script> --}}

<script>
    var doughnutPieData = {
        labels: ['Sesuai Infokom', 'Tidak Sesuai Infokom'],
        datasets: [{
            data: [
                {{ $data->sum('infokom') }},
                {{ $data->sum('non_infokom') }}
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 99, 132, 0.5)'
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

    $(document).ready(function () {
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
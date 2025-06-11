@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin - Kepuasan Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome untuk ikon -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Animate.css untuk animasi -->
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1e293b;
        }

        .content {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 280px;
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chart-container canvas {
            max-width: 100%;
            max-height: 100%;
        }

        .header-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .subtitle {
            font-size: 1.1rem;
            color: #64748b;
            max-width: 700px;
        }

        .form-select {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
            max-width: 300px;
        }

        .stat-card {
            background: #fff;
            border-left: 4px solid #3b82f6;
        }

        .stat-card h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-card p {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate__animated {
            animation-duration: 0.8s;
        }

        .card-header {
            padding: 1rem 1.5rem;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-body {
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .table-responsive {
            margin-top: 1rem;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .jenis-kemampuan {
            text-align: left;
        }

        @media (max-width: 768px) {
            .content {
                padding: 1rem;
            }
            .header-title {
                font-size: 1.6rem;
            }
            .chart-container {
                height: 220px;
            }
            .form-select {
                max-width: 100%;
            }
            .stat-card h2 {
                font-size: 2rem;
            }
            .table {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <div class="row mb-5 animate__animated animate__fadeIn">
           
        </div>

        <!-- Statistik Jumlah -->
        <div class="row mb-5 animate__animated animate__fadeInUp">
            <!-- Jumlah Alumni -->
            <div class="col-lg-3 col-12 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h2>{{ $jumlahAlumni }}</h2>
                        <p>Jumlah Alumni</p>
                    </div>
                </div>
            </div>
            <!-- Jumlah Pengguna Lulusan -->
            <div class="col-lg-3 col-12 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h2>{{ $jumlahPenggunaLulusan }}</h2>
                        <p>Jumlah Pengguna Lulusan</p>
                    </div>
                </div>
            </div>
            <!-- Jumlah Tracer Study -->
            <div class="col-lg-3 col-12 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h2>{{ $jumlahTracerStudy }}</h2>
                        <p>Jumlah Tracer Study</p>
                    </div>
                </div>
            </div>
            <!-- Jumlah Pengguna Survei -->
            <div class="col-lg-3 col-12 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h2>{{ $jumlahPenggunaSurvei }}</h2>
                        <p>Jumlah Pengguna Survei</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Distribusi (Horizontal) -->
        <div class="row animate__animated animate__fadeInUp">
            <!-- Card Distribusi Jawaban -->
            <div class="col-lg-4 col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Distribusi Jawaban</h5>
                        <div>
                            <select id="kategoriFilter" class="form-select" onchange="filterChart()">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriList as $kode => $nama)
                                    <option value="{{ $kode }}" {{ $selectedKategori == $kode ? 'selected' : '' }}>{{ $kode }} - {{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="pieChart" width="240" height="240"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Distribusi Instansi -->
            <div class="col-lg-4 col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Distribusi Instansi</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="instansiDonutChart" width="240" height="240"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Distribusi Profesi -->
            <div class="col-lg-4 col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Distribusi Profesi</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="profesiDonutChart" width="240" height="240"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Kategori Pertanyaan -->
        <div class="row mb-5 animate__animated animate__fadeInUp">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Distribusi Jawaban per Kategori</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                <tbody>
                                    @foreach($kategoriJawaban as $index => $kategori)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="jenis-kemampuan">{{ $kategori['nama_kategori'] }}</td>
                                            <td>{{ $kategori['sangat_baik'] }}%</td>
                                            <td>{{ $kategori['baik'] }}%</td>
                                            <td>{{ $kategori['cukup'] }}%</td>
                                            <td>{{ $kategori['kurang'] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><strong>Rata-rata Total</strong></td>
                                        <td id="footer-sangat-baik" class="fw-bold">{{ round($rataRataTabel['sangat_baik'], 2) }}%</td>
                                        <td id="footer-baik" class="fw-bold">{{ round($rataRataTabel['baik'], 2) }}%</td>
                                        <td id="footer-cukup" class="fw-bold">{{ round($rataRataTabel['cukup'], 2) }}%</td>
                                        <td id="footer-kurang" class="fw-bold">{{ round($rataRataTabel['kurang'], 2) }}%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data awal dari server
        const distribusiData = @json($distribusiData);
        const instansiData = @json($instansiData);
        const profesiData = @json($profesiData);
        let currentChart = null;
        let instansiChart = null;
        let profesiChart = null;

        // Fungsi untuk merender chart kepuasan
        function renderKategoriChart(selectedKategori) {
            if (currentChart) {
                currentChart.destroy();
            }

            const ctx = document.getElementById('pieChart').getContext('2d');
            let chartData = {
                labels: ['Sangat Tidak Puas (1)', 'Tidak Puas (2)', 'Cukup (3)', 'Puas (4)', 'Sangat Puas (5)'],
                datasets: [{
                    data: [0, 0, 0, 0, 0],
                    backgroundColor: ['#ef4444', '#f97316', '#facc15', '#22c55e', '#3b82f6'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            };

            if (!selectedKategori) {
                let combined = [0, 0, 0, 0, 0];
                for (let kode in distribusiData) {
                    for (let i = 1; i <= 5; i++) {
                        combined[i - 1] += distribusiData[kode].distribusi[i];
                    }
                }
                chartData.datasets[0].data = combined;
            } else if (distribusiData[selectedKategori]) {
                chartData.datasets[0].data = [
                    distribusiData[selectedKategori].distribusi[1],
                    distribusiData[selectedKategori].distribusi[2],
                    distribusiData[selectedKategori].distribusi[3],
                    distribusiData[selectedKategori].distribusi[4],
                    distribusiData[selectedKategori].distribusi[5]
                ];
            }

            currentChart = new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart',
                        delay: 300
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: { size: 11 },
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e3a8a',
                            titleFont: { size: 12, weight: '600' },
                            bodyFont: { size: 11 },
                            padding: 12,
                            cornerRadius: 8
                        },
                        title: {
                            display: true,
                            text: selectedKategori ? 
                                (distribusiData[selectedKategori] ? `${selectedKategori} - ${distribusiData[selectedKategori].nama}` : 'Kategori Tidak Ditemukan') : 
                                'Semua Kategori',
                            font: { size: 16, weight: '600' },
                            color: '#1e293b',
                            padding: 20
                        }
                    }
                }
            });
        }

        // Fungsi untuk merender chart instansi
        function renderInstansiChart() {
            if (instansiChart) {
                instansiChart.destroy();
            }

            const ctx = document.getElementById('instansiDonutChart').getContext('2d');
            let chartData = {
                labels: instansiData.map(item => item.jenis_instansi),
                datasets: [{
                    data: instansiData.map(item => item.total),
                    backgroundColor: ['#004E7C', '#5BAEB7', '#9B9B9B', '#1E80C1'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            };

            instansiChart = new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart',
                        delay: 300
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: { size: 11 },
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e3a8a',
                            titleFont: { size: 12, weight: '600' },
                            bodyFont: { size: 11 },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    return `${label}: ${value} alumni`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Distribusi Instansi Alumni',
                            font: { size: 16, weight: '600' },
                            color: '#1e293b',
                            padding: 20
                        }
                    }
                }
            });
        }

        // Fungsi untuk merender chart profesi
        function renderProfesiChart() {
            if (profesiChart) {
                profesiChart.destroy();
            }

            const ctx = document.getElementById('profesiDonutChart').getContext('2d');
            let chartData = {
                labels: profesiData.map(item => item.nama_profesi),
                datasets: [{
                    data: profesiData.map(item => item.total),
                    backgroundColor: [
                        '#004E7C', '#0077B6', '#0096C7', '#00B4D8', '#48CAE4',
                        '#90E0EF', '#CAF0F8', '#023E8A', '#007F5F', '#00B894'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            };

            profesiChart = new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart',
                        delay: 300
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: { size: 11 },
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e3a8a',
                            titleFont: { size: 12, weight: '600' },
                            bodyFont: { size: 11 },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    return `${label}: ${value} alumni`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: '10 Profesi Teratas',
                            font: { size: 16, weight: '600' },
                            color: '#1e293b',
                            padding: 20
                        }
                    }
                }
            });
        }

        // Fungsi filter saat dropdown berubah
        function filterChart() {
            const selectedKategori = document.getElementById('kategoriFilter').value;
            renderKategoriChart(selectedKategori);
        }

        // Render chart awal
        renderKategoriChart('{{ $selectedKategori }}');
        renderInstansiChart();
        renderProfesiChart();
    </script>
</body>
</html>
@endsection
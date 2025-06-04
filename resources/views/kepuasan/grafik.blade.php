@extends('layouts.template')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Grafik Kepuasan Pengguna</title>
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

        .navbar {
           background:rgb(58, 110, 255);
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

     .stat-card {
    background:rgb(58, 110, 255);
    color: #fff;
    border-radius: 10px;
}


        .chart-container {
            position: relative;
            height: 450px;
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        .mini-chart {
            height: 280px;
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
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

        .badge {
            font-size: 0.95rem;
            padding: 0.6em 1.2em;
            border-radius: 50px;
            font-weight: 500;
        }

        .table th, .table td {
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .table thead {
            background-color: #1e3a8a;
            color: #fff;
        }

        .btn-filter {
            background-color: #3b82f6;
            color: #fff;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-filter:hover {
            background-color: #2563eb;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate__animated {
            animation-duration: 0.8s;
        }

        @media (max-width: 768px) {
            .header-title {
                font-size: 1.6rem;
            }
            .chart-container {
                height: 350px;
            }
            .mini-chart {
                height: 220px;
            }
            .navbar {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Kepuasan Pengguna</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
   
        </div>
    </nav>

    <div class="container-fluid mt-5">
        <!-- Header -->
        <div class="row mb-5 animate__animated animate__fadeIn">
            <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h2 class="header-title mb-2"><i class="fas fa-chart-line me-2"></i>Grafik Kepuasan Pengguna Lulusan</h2>
                    <p class="subtitle mb-0">Analisis mendalam terhadap tingkat kepuasan pengguna lulusan berdasarkan kriteria penilaian, dirancang untuk presentasi profesional dan pengambilan keputusan strategis.</p>
                </div>
              
            </div>
        </div>

        <!-- Statistik Keseluruhan -->
        <div class="row mb-5 animate__animated animate__fadeInUp">
            <div class="col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <h5 class="mb-3"><i class="fas fa-star me-2"></i>Rata-rata Kepuasan Keseluruhan</h5>
                        <h1 class="display-4">{{ $rataRataKeseluruhan }}/5.0</h1>
                        <p class="mb-0">Berdasarkan {{ $totalJawaban }} jawaban</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="mb-3"><i class="fas fa-chart-bar me-2"></i>Status Kepuasan</h5>
                        <h2 class="
                            @if($rataRataKeseluruhan >= 4.0) text-success
                            @elseif($rataRataKeseluruhan >= 3.0) text-primary
                            @elseif($rataRataKeseluruhan >= 2.0) text-warning
                            @else text-danger
                            @endif">
                            @if($rataRataKeseluruhan >= 4.0)
                                <i class="fas fa-star me-2"></i>Sangat Memuaskan
                            @elseif($rataRataKeseluruhan >= 3.0)
                                <i class="fas fa-smile me-2"></i>Memuaskan
                            @elseif($rataRataKeseluruhan >= 2.0)
                                <i class="fas fa-meh me-2"></i>Cukup
                            @else
                                <i class="fas fa-frown me-2"></i>Perlu Perbaikan
                            @endif
                        </h2>
                        <small class="text-muted">Evaluasi berdasarkan skala 1-5</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Utama -->
        <div class="row mb-5 animate__animated animate__fadeInUp">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Rata-rata Kepuasan per Kategori</h5>
                        <small class="text-muted">Visualisasi rata-rata penilaian untuk setiap kategori</small>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Detail per Kategori</h5>
                        <small class="text-muted">Rincian rata-rata dan jumlah responden</small>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Rata-rata</th>
                                        <th>Responden</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rataRataKategori as $item)
                                    <tr>
                                        <td><strong>{{ $item['kode'] }}</strong></td>
                                        <td>
                                            <span class="badge 
                                                @if($item['rata_rata'] >= 4.0) bg-success
                                                @elseif($item['rata_rata'] >= 3.0) bg-primary
                                                @elseif($item['rata_rata'] >= 2.0) bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $item['rata_rata'] }}
                                            </span>
                                        </td>
                                        <td>{{ $item['total_responden'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Distribusi -->
        <div class="row mb-5 animate__animated animate__fadeInUp">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Distribusi Jawaban per Kategori</h5>
                        <small class="text-muted">Sebaran jawaban (skala 1-5) untuk setiap kategori penilaian</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($distribusiData as $kode => $data)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">{{ $kode }} - {{ $data['nama'] }}</h6>
                                        <div class="mini-chart">
                                            <canvas id="pieChart{{ $kode }}"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Detail -->
        <div class="row animate__animated animate__fadeInUp">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Detail Pertanyaan dan Hasil Penilaian</h5>
                        <small class="text-muted">Rincian lengkap pertanyaan, rata-rata, dan status kepuasan</small>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Pertanyaan</th>
                                        <th>Rata-rata</th>
                                        <th>Total Responden</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rataRataKategori as $item)
                                    <tr>
                                        <td><strong>{{ $item['kode'] }}</strong></td>
                                        <td>{{ Str::limit($item['pertanyaan'], 80) }}</td>
                                        <td>
                                            <span class="badge badge-lg
                                                @if($item['rata_rata'] >= 4.0) bg-success
                                                @elseif($item['rata_rata'] >= 3.0) bg-primary  
                                                @elseif($item['rata_rata'] >= 2.0) bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $item['rata_rata'] }}/5.0
                                            </span>
                                        </td>
                                        <td>{{ $item['total_responden'] }} orang</td>
                                        <td>
                                            @if($item['rata_rata'] >= 4.0)
                                                <span class="text-success"><i class="fas fa-star me-1"></i>Sangat Baik</span>
                                            @elseif($item['rata_rata'] >= 3.0)
                                                <span class="text-primary"><i class="fas fa-smile me-1"></i>Baik</span>
                                            @elseif($item['rata_rata'] >= 2.0)
                                                <span class="text-warning"><i class="fas fa-meh me-1"></i>Cukup</span>
                                            @else
                                                <span class="text-danger"><i class="fas fa-frown me-1"></i>Perlu Perbaikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
    // Bar Chart untuk Rata-rata Kepuasan
    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {!! json_encode($chartData) !!},
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1200,
                easing: 'easeOutQuart',
                delay: 200
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e3a8a',
                    titleFont: { size: 14, weight: '600' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw.toFixed(2)} ★`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1,
                        callback: value => `${value} ★`,
                        font: { size: 12 }
                    },
                    title: {
                        display: true,
                        text: 'Tingkat Kepuasan (Skala 1–5)',
                        font: { size: 14, weight: '600' },
                        color: '#1e293b'
                    },
                    grid: {
                        color: '#e2e8f0'
                    }
                },
                x: {
                    ticks: {
                        font: { size: 12 }
                    },
                    title: {
                        display: true,
                        text: 'Kategori Penilaian',
                        font: { size: 14, weight: '600' },
                        color: '#1e293b'
                    }
                }
            }
        }
    });

    // Pie Charts untuk Distribusi per Kategori
    @foreach($distribusiData as $kode => $data)
    const pieCtx{{ $kode }} = document.getElementById('pieChart{{ $kode }}').getContext('2d');
    const pieChart{{ $kode }} = new Chart(pieCtx{{ $kode }}, {
        type: 'doughnut',
        data: {
            labels: ['Sangat Tidak Puas (1)', 'Tidak Puas (2)', 'Cukup (3)', 'Puas (4)', 'Sangat Puas (5)'],
            datasets: [{
                data: [
                    {{ $data['distribusi'][1] }},
                    {{ $data['distribusi'][2] }},
                    {{ $data['distribusi'][3] }},
                    {{ $data['distribusi'][4] }},
                    {{ $data['distribusi'][5] }}
                ],
                backgroundColor: [
                    '#ef4444',
                    '#f97316',
                    '#facc15',
                    '#22c55e',
                    '#3b82f6'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
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
                }
            }
        }
    });
    @endforeach
    </script>
</body>
</html>
@endsection
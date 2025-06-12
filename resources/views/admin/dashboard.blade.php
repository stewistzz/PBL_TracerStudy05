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
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('skydash/template/css/style_dashbaord.css') }}">

    <style>
        /* Font default untuk seluruh dashboard */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
        }

        /* Styling untuk card */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        /* Styling untuk header */
        .card-header {
            background-color: #1E80C1;
            color: #ffffff;
            border-radius: 12px 12px 0 0;
            padding: 15px 20px;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header i {
            font-size: 1.2rem;
            color: #ffffff;
        }

        /* Styling untuk body card */
        .card-body {
            padding: 20px;
        }

        /* Styling untuk chart container */
        .chart-container {
            position: relative;
            margin: 0 auto;
            width: 100%;
            max-width: 240px;
            height: 240px;
        }

        /* Styling untuk dropdown filter */
        .form-select {
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 8px;
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            transition: border-color 0.3s ease;
        }

        .form-select:focus {
            border-color: #1E80C1;
            box-shadow: 0 0 0 3px rgba(30, 128, 193, 0.1);
        }

        /* Styling untuk card tale (card box lainnya) */
        .card.card-tale {
            border-radius: 15px;
            overflow: hidden;
        }

        .card.card-tale .card-body {
            padding: 20px;
        }

        .card.card-tale p.fs-30 {
            font-size: 2rem;
            font-weight: 700;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header {
                font-size: 1rem;
            }

            .chart-container {
                max-width: 200px;
                height: 200px;
            }

            .card.card-tale p.fs-30 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Main Content -->
    <div class="content">
        {{-- Welcome --}}
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex flex-column flex-xl-row justify-content-between align-items-start align-items-xl-center">
                    <div>
                        <h3 class="font-weight-bold mb-2">Welcome, Admin Tracer Study!</h3>
                        <h5 class="font-weight-normal mb-0 py-2">You are logged in as {{ Auth::user()->admin->nama }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Illustrasi dan Card Box --}}
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card-people mt-auto text-center">
                    <img src="{{ asset('skydash/template/images/ilustrasi.png') }}" alt="ilustrasi" style="width:65%;height:auto;">
                </div>
            </div>

            {{-- Card Box --}}
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    {{-- Alumni --}}
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale h-100" style="background-color:#2A3143;">
                            <div class="card-body d-flex flex-column justify-content-between text-white">
                                <div>
                                    <p class="mb-2 fw-bold">Data Alumni</p>
                                    <p class="fs-30 mb-2">{{ $jumlahAlumni }}</p>
                                </div>
                                <p class="mt-auto">Politeknik Negeri Malang</p>
                            </div>
                        </div>
                    </div>
                    {{-- Pengguna --}}
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale h-100" style="background-color:#5BAEB7;">
                            <div class="card-body d-flex flex-column justify-content-between text-white">
                                <div>
                                    <p class="mb-2 fw-bold">Data Pengguna</p>
                                    <p class="fs-30 mb-2">{{ $jumlahPenggunaLulusan }}</p>
                                </div>
                                <p class="mt-auto">Atasan Pengguna</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Tracer --}}
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-tale h-100" style="background-color:#1E80C1;">
                            <div class="card-body d-flex flex-column justify-content-between text-white">
                                <div>
                                    <p class="mb-2 fw-bold">Tracer Study</p>
                                    <p class="fs-30 mb-2">{{ $jumlahTracerStudy }}</p>
                                </div>
                                <p class="mt-auto">Politeknik Negeri Malang</p>
                            </div>
                        </div>
                    </div>
                    {{-- Survei --}}
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-tale h-100 text-dark" style="background-color:#B8B8B8;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <p class="mb-2 fw-bold">Survei Kepuasan</p>
                                    <p class="fs-30 mb-2">{{ $jumlahPenggunaSurvei }}</p>
                                </div>
                                <p class="mt-auto">Atasan Pengguna</p>
                            </div>
                        </div>
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
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-chart-pie"></i>
                            <h5 class="mb-0">Distribusi Jawaban</h5>
                        </div>
                        <div>
                            <select id="kategoriFilter" class="form-select" onchange="filterChart()">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoriList as $kode => $nama)
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
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-building"></i>
                            <h5 class="mb-0">Distribusi Instansi</h5>
                        </div>
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
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-briefcase"></i>
                            <h5 class="mb-0">Distribusi Profesi</h5>
                        </div>
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
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-table"></i>
                            <h5 class="mb-0">Distribusi Jawaban per Kategori</h5>
                        </div>
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
                                    @foreach ($kategoriJawaban as $index => $kategori)
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
                    backgroundColor: ['#004E7C', '#5BAEB7', '#9B9B9B', '#1E80C1', '#0096C7'],
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
                                font: {
                                    size: 12,
                                    family: 'Poppins',
                                    weight: '500'
                                },
                                padding: 15,
                                color: '#1e293b'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e3a8a',
                            titleFont: {
                                size: 14,
                                family: 'Poppins',
                                weight: '600'
                            },
                            bodyFont: {
                                size: 12,
                                family: 'Poppins'
                            },
                            padding: 12,
                            cornerRadius: 8
                        },
                        title: {
                            display: true,
                            text: selectedKategori ?
                                (distribusiData[selectedKategori] ?
                                    `${selectedKategori} - ${distribusiData[selectedKategori].nama}` :
                                    'Kategori Tidak Ditemukan') : 'Semua Kategori',
                            font: {
                                size: 16,
                                family: 'Poppins',
                                weight: '600'
                            },
                            color: '#1e293b',
                            padding: {
                                top: 10,
                                bottom: 20
                            }
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
                                font: {
                                    size: 12,
                                    family: 'Poppins',
                                    weight: '500'
                                },
                                padding: 15,
                                color: '#1e293b'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e3a8a',
                            titleFont: {
                                size: 14,
                                family: 'Poppins',
                                weight: '600'
                            },
                            bodyFont: {
                                size: 12,
                                family: 'Poppins'
                            },
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
                            font: {
                                size: 16,
                                family: 'Poppins',
                                weight: '600'
                            },
                            color: '#1e293b',
                            padding: {
                                top: 10,
                                bottom: 20
                            }
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
                                font: {
                                    size: 12,
                                    family: 'Poppins',
                                    weight: '500'
                                },
                                padding: 15,
                                color: '#1e293b'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e3a8a',
                            titleFont: {
                                size: 14,
                                family: 'Poppins',
                                weight: '600'
                            },
                            bodyFont: {
                                size: 12,
                                family: 'Poppins'
                            },
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
                            font: {
                                size: 16,
                                family: 'Poppins',
                                weight: '600'
                            },
                            color: '#1e293b',
                            padding: {
                                top: 10,
                                bottom: 20
                            }
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
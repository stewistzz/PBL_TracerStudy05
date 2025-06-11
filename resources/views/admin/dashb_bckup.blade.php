@extends('layouts.template')

@push('styles')
    <!-- Vendor CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome untuk ikon -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Animate.css untuk animasi -->
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('skydash/template/css/style_dashbaord.css') }}">
@endpush

@section('content')


{{-- header --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0" style="color: #2A3143;">
                    <i class="mdi mdi-city-variant-outline mr-1"></i>Sebaran Instansi Alumni
                </h4>
            </div>
            <hr>
            <p class="card-description text-muted">
                Tabel ini menampilkan sebaran instansi alumni dari waktu kelulusan hingga tanggal pertama bekerja.
            </p>
        </div>
    </div>
    

    {{-- illustrasi --}}
    <div class="row mb-3">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card-people mt-auto text-center">
                <img src="{{ asset('skydash/template/images/ilustrasi.png') }}" alt="ilustrasi"
                    style="width:65%;height:auto;">
            </div>
        </div>

        {{-- card box --}}
        <!-- <div class="col-md-3 grid-margin transparent">
            <div class="row"> -->
                {{-- alumni --}}
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-tale" style="background-color:#2A3143;">
                        <div class="card-body">
                            <p class="mb-4">Data Alumni</p>
                            <p class="fs-30 mb-2">{{ $jumlahAlumni }}</p>
                            <p>Politeknik Negeri Malang</p>
                        </div>
                    </div>
                </div>
                {{-- pengguna --}}
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-tale" style="background-color:#5BAEB7;">
                        <div class="card-body">
                            <p class="mb-4">Data Pengguna</p>
                            <p class="fs-30 mb-2">{{ $jumlahPengguna }}</p>
                            <p>Atasan Pengguna</p>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
            {{-- tracer --}}
            <!-- <div class="row"> -->
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-tale" style="background-color:#1E80C1;">
                        <div class="card-body">
                            <p class="mb-4">Tracer Study</p>
                            <p class="fs-30 mb-2">{{ $jumlahTracer }}</p>
                            <p>Politeknik Negeri Malang</p>
                        </div>
                    </div>
                </div>
                {{-- survei --}}
                <div class="col-md-3 mb-4 stretch-card transparent">
                    <div class="card card-tale text-dark" style="background-color:#B8B8B8;">
                        <div class="card-body">
                            <p class="mb-4">Survei Kepuasan</p>
                            <p class="fs-30 mb-2">{{ $jumlahSurvei }}</p>
                            <p>Atasan Pengguna</p>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        <!-- </div> -->
    </div>

    {{-- ------------------------------ GRAFIK --------------------------- --}}
    <div class="row">
        {{-- chart bar kepuasan --}}
        <div class="col-lg-8 mb-4 animate__animated animate__fadeInUp">
            <div class="card ">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 py-2"><i class="fas fa-chart-bar me-2"></i>Rata-rata Kepuasan per Kategori</h5>
                    <small class="text-muted">Visualisasi rata-rata penilaian untuk setiap kategori</small>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- instansii --}}
        <div class="col-lg-4 mb-4">
            <div class="card rounded-4">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold mb-4">Sebaran Jenis Instansi</h4>
                    <canvas id="instansiChart" width="240" height="240"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- Pie chart masa tunggu --}}
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card rounded-4">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold mb-4">Sebaran Masa Tunggu Alumni</h4>
                    <canvas id="masaTungguChart" width="240" height="240"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        titleFont: {
                            size: 14,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 12
                        },
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
                            font: {
                                size: 12
                            }
                        },
                        title: {
                            display: true,
                            text: 'Tingkat Kepuasan (Skala 1–5)',
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            color: '#1e293b'
                        },
                        grid: {
                            color: '#e2e8f0'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            }
                        },
                        title: {
                            display: true,
                            text: 'Kategori Penilaian',
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            color: '#1e293b'
                        }
                    }
                }
            }
        });

        // {{-- Script Pie Chart --}}


        const instansiCtx = document.getElementById('instansiChart').getContext('2d');

        const instansiChart = new Chart(instansiCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($instansiData->pluck('jenis_instansi')->toArray()) !!},
                datasets: [{
                    label: 'Sebaran Jenis Instansi Alumni',
                    data: {!! json_encode($instansiData->pluck('total')->toArray()) !!},
                    backgroundColor: [
                        '#004E7C', '#5BAEB7', '#9B9B9B', '#1E80C1',
                        '#6DA9C1', '#007599'
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



        // masatunggu
        const masaTungguCtx = document.getElementById('masaTungguChart').getContext('2d');
        const masaTungguChart = new Chart(masaTungguCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($kategoriMasaTunggu)) !!},
                datasets: [{
                    label: 'Sebaran Masa Tunggu',
                    data: {!! json_encode(array_values($kategoriMasaTunggu)) !!},
                    backgroundColor: [
                        '#0f766e', '#2dd4bf', '#38bdf8', '#6366f1', '#f87171'
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
                                return `${label}: ${value} alumni`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush

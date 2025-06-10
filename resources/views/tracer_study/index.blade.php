@extends('layouts.template')

@section('content')
<style>
    .completion-card {
        background: linear-gradient(135deg, #007bff 0%, #17a2b8 100%);
        color: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .completion-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    .completion-icon {
        animation: pulse 2s infinite;
        background: #28a745 !important;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .summary-card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .badge-success {
        background: #28a745;
        color: white;
    }
    .btn-primary {
        background: #007bff;
        border: none;
        border-radius: 25px;
        padding: 10px 30px;
        font-weight: 600;
        transition: background 0.3s ease;
    }
    .btn-primary:hover {
        background: #0056b3;
    }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0">Tracer Study</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if($isCompleted)
                        <div class="text-center py-4">
                            <div class="mb-4">
                                <i class="fas fa-check-circle fa-5x text-white completion-icon" style="border-radius: 50%; padding: 20px;"></i>
                            </div>
                            <h4 class="card-title mb-3" style="color: #ffc107;">Selamat! Tracer Study Anda Telah Selesai</h4>
                            <p class="card-description text-muted mb-4">
                                Terima kasih telah melengkapi Tracer Study. Kontribusi Anda sangat berarti bagi kemajuan institusi kami.
                            </p>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="card summary-card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">Ringkasan Pengisian</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <span><i class="fas fa-user mr-2"></i> Data Diri</span>
                                                    <span class="badge badge-success badge-pill">Selesai</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <span><i class="fas fa-user-tie mr-2"></i> Data Atasan</span>
                                                    <span class="badge badge-success badge-pill">Selesai</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <span><i class="fas fa-question-circle mr-2"></i> Kuesioner</span>
                                                    <span class="badge badge-success badge-pill">Selesai</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('tracer-study.success') }}" class="btn btn-primary">
                                    <i class="fas fa-eye mr-2"></i> Lihat Hasil
                                </a>
                            </div>
                        </div>
                    @else
                        <h4 class="card-title">Progres Pengisian Tracer Study</h4>
                        <p class="card-description">Lengkapi semua langkah untuk menyelesaikan tracer study.</p>
                        
                        <div class="progress mb-4">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ ($progress['data_diri'] ? 33 : 0) + ($progress['data_atasan'] ? 33 : 0) + ($progress['kuesioner'] ? 34 : 0) }}%" 
                                 aria-valuenow="{{ ($progress['data_diri'] ? 33 : 0) + ($progress['data_atasan'] ? 33 : 0) + ($progress['kuesioner'] ? 34 : 0) }}" 
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border-primary mb-3">
                                    <div class="card-header {{ $progress['data_diri'] ? 'bg-success text-white' : 'bg-primary text-white' }}">
                                        <h5 class="card-title mb-0">Data Diri</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Lengkapi informasi pribadi dan pekerjaan Anda.</p>
                                        <a href="{{ route('tracer-study.data-diri') }}" 
                                           class="btn {{ $progress['data_diri'] ? 'btn-outline-success' : 'btn-primary' }}">
                                            {{ $progress['data_diri'] ? 'Sudah Diisi' : 'Isi Sekarang' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-primary mb-3">
                                    <div class="card-header {{ $progress['data_atasan'] ? 'bg-success text-white' : 'bg-primary text-white' }}">
                                        <h5 class="card-title mb-0">Data Atasan</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Masukkan informasi atasan langsung Anda.</p>
                                        <a href="{{ route('tracer-study.data-atasan') }}" 
                                           class="btn {{ $progress['data_atasan'] ? 'btn-outline-success' : 'btn-primary' }} {{ !$progress['data_diri'] ? 'disabled' : '' }}">
                                            {{ $progress['data_atasan'] ? 'Sudah Diisi' : 'Isi Sekarang' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-primary mb-3">
                                    <div class="card-header {{ $progress['kuesioner'] ? 'bg-success text-white' : 'bg-primary text-white' }}">
                                        <h5 class="card-title mb-0">Kuesioner</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Jawab pertanyaan terkait pengalaman kerja Anda.</p>
                                        <a href="{{ route('tracer-study.kuesioner') }}" 
                                           class="btn {{ $progress['kuesioner'] ? 'btn-outline-success' : 'btn-primary' }} {{ !$progress['data_atasan'] ? 'disabled' : '' }}">
                                            {{ $progress['kuesioner'] ? 'Sudah Diisi' : 'Isi Sekarang' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
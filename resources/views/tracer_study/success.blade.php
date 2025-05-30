@extends('layouts.template')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center py-5">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="mx-auto bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-check text-white" style="font-size: 2rem;"></i>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <h2 class="text-success mb-3">Tracer Study Berhasil Diselesaikan!</h2>
                    <p class="text-muted mb-4 lead">
                        Terima kasih telah meluangkan waktu untuk mengisi Tracer Study. 
                        Data yang Anda berikan sangat berharga untuk pengembangan program studi.
                    </p>

                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Information Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body py-3">
                                    <i class="fas fa-calendar-check text-primary mb-2" style="font-size: 1.5rem;"></i>
                                    <h6 class="card-title mb-1">Status</h6>
                                    <p class="card-text text-success fw-bold mb-0">Selesai</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body py-3">
                                    <i class="fas fa-clock text-info mb-2" style="font-size: 1.5rem;"></i>
                                    <h6 class="card-title mb-1">Waktu Selesai</h6>
                                    <p class="card-text mb-0">{{ now()->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body py-3">
                                    <i class="fas fa-user-graduate text-warning mb-2" style="font-size: 1.5rem;"></i>
                                    <h6 class="card-title mb-1">Alumni</h6>
                                    <p class="card-text mb-0">{{ auth()->user()->name ?? 'Alumni' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Langkah Selanjutnya
                            </h5>
                            <p class="card-text mb-0">
                                Data tracer study Anda telah tersimpan dengan aman. Tim akademik akan menganalisis data ini untuk meningkatkan kualitas pendidikan dan layanan kepada mahasiswa.
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('alumni_i.dashboard') }}" class="btn btn-primary px-4">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Dashboard
                        </a>
                        <a href="{{ route('tracer-study.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-eye me-2"></i>
                            Lihat Data Tracer Study
                        </a>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted mb-2">
                            <small>
                                Jika ada pertanyaan atau masalah terkait tracer study, 
                                silakan hubungi tim akademik melalui:
                            </small>
                        </p>
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <small class="text-muted">
                                <i class="fas fa-envelope me-1"></i>
                                polinemajos@university.edu
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-phone me-1"></i>
                                (021) 123-4567
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Animation CSS -->
<style>
    .card {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .bg-success {
        animation: bounce 0.8s ease-out;
    }
    
    @keyframes bounce {
        0%, 20%, 60%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        80% {
            transform: translateY(-5px);
        }
    }
</style>
@endsection
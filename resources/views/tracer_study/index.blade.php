@extends('layouts.template')

@section('content')
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

                    @if ($progress['kuesioner'])
                        <div class="alert alert-success" role="alert">
                            Selamat! Anda telah menyelesaikan Tracer Study. 
                            <a href="{{ route('tracer-study.success') }}" class="alert-link">Lihat hasil</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
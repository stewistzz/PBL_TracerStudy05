@extends('layouts.template')

@section('content')

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h3 class="font-weight-bold">Welcome to Tracer Study!</h3><br>
            <h4>Good to see you again {{ Auth::user()->alumni->nama }}.</h4>
        </div>
    </div>

    {{-- <!-- Statistik singkat -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Data Diri</h5>
                    <p class="card-text display-5">Lengkap</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tracer Study</h5>
                    <p class="card-text display-5">Sudah</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Alumni</h5>
                    <p class="card-text display-5">1,234</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Update Terbaru</h5>
                    <p class="card-text">Seminar Alumni Bulan Depan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcut ke fitur utama -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-3" width="48" height="48" fill="#0d6efd" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z"/>
                        <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                    <h5 class="card-title">Isi Data Diri</h5>
                    <p class="card-text">Lengkapi informasi pribadi dan kontak Anda.</p>
                    <a href="#" class="btn btn-primary">Isi Sekarang</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-3" width="48" height="48" fill="#198754" viewBox="0 0 16 16">
                        <path d="M1 2.828c.885-.37 2.154-.662 3.68-.77a.5.5 0 0 1 .168.975c-1.272.219-2.388.683-3.116 1.404A.5.5 0 0 1 1 4.5v-1.672z"/>
                        <path d="M5 3.5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 5 3.5z"/>
                        <path d="M7.5 5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M10 6a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 10 6z"/>
                    </svg>
                    <h5 class="card-title">Tracer Study</h5>
                    <p class="card-text">Isi survei tracer study untuk alumni.</p>
                    <a href="#" class="btn btn-success">Isi Survei</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mb-3" width="48" height="48" fill="#0dcaf0" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z"/>
                        <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                    <h5 class="card-title">Profil Saya</h5>
                    <p class="card-text">Lihat dan update profil Anda.</p>
                    <a href="#" class="btn btn-info">Lihat Profil</a>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Berita / Pengumuman -->
    <div class="row">
        <div class="col-md-12">
            <h5>Berita & Pengumuman Terbaru</h5>
            <ul class="list-group shadow-sm">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Seminar Online Alumni 2025</strong>
                        <p class="mb-0 text-muted small">Jangan lewatkan seminar online alumni pada 10 Juli 2025.</p>
                    </div>
                    <small class="text-muted">10 Jun 2025</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Pendaftaran Beasiswa Alumni</strong>
                        <p class="mb-0 text-muted small">Beasiswa khusus alumni dibuka mulai Agustus 2025.</p>
                    </div>
                    <small class="text-muted">1 Jun 2025</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Gathering Akbar Alumni</strong>
                        <p class="mb-0 text-muted small">Acara kumpul alumni besar-besaran akan diadakan September 2025.</p>
                    </div>
                    <small class="text-muted">28 Mei 2025</small>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

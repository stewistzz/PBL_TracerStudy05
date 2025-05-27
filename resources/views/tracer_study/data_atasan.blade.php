@extends('layouts.template')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Atasan Langsung</h4>
                    <p class="card-description">Masukkan informasi atasan langsung Anda untuk keperluan survei.</p>
                    
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tracer-study.store-data-atasan') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_atasan_langsung">Nama Atasan Langsung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_atasan_langsung') is-invalid @enderror" 
                                   id="nama_atasan_langsung" name="nama_atasan_langsung" 
                                   value="{{ old('nama_atasan_langsung', $tracerStudy->nama_atasan_langsung ?? '') }}"
                                   required>
                            @error('nama_atasan_langsung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jabatan_atasan_langsung">Jabatan Atasan Langsung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jabatan_atasan_langsung') is-invalid @enderror" 
                                   id="jabatan_atasan_langsung" name="jabatan_atasan_langsung" 
                                   value="{{ old('jabatan_atasan_langsung', $tracerStudy->jabatan_atasan_langsung ?? '') }}"
                                   required>
                            @error('jabatan_atasan_langsung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp_atasan_langsung">Nomor HP Atasan Langsung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_hp_atasan_langsung') is-invalid @enderror" 
                                   id="no_hp_atasan_langsung" name="no_hp_atasan_langsung" 
                                   value="{{ old('no_hp_atasan_langsung', $tracerStudy->no_hp_atasan_langsung ?? '') }}"
                                   required>
                            @error('no_hp_atasan_langsung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email_atasan_langsung">Email Atasan Langsung <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email_atasan_langsung') is-invalid @enderror" 
                                   id="email_atasan_langsung" name="email_atasan_langsung" 
                                   value="{{ old('email_atasan_langsung', $tracerStudy->email_atasan_langsung ?? '') }}"
                                   required>
                            @error('email_atasan_langsung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan dan Lanjutkan</button>
                        <a href="{{ route('tracer-study.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.template')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Diri</h4>
                    <p class="card-description">Lengkapi informasi pribadi dan pekerjaan Anda.</p>
                    
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

                    <form action="{{ route('tracer-study.store-data-diri') }}" method="POST">
                        @csrf
                          <div class="form-group">
                            <label for="nama">NIM</label>
                            <input type="text" class="form-control" id="nama" value="{{ $alumni->nim ?? '' }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" value="{{ $alumni->nama ?? '' }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pertama_kerja">Tanggal Pertama Kerja <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pertama_kerja') is-invalid @enderror" 
                                   id="tanggal_pertama_kerja" name="tanggal_pertama_kerja" 
                                   value="{{ old('tanggal_pertama_kerja', $tracerStudy->tanggal_pertama_kerja ?? '') }}"
                                   required>
                            @error('tanggal_pertama_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai_kerja_instansi_saat_ini">Tanggal Mulai Kerja di Instansi Saat Ini <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_mulai_kerja_instansi_saat_ini') is-invalid @enderror" 
                                   id="tanggal_mulai_kerja_instansi_saat_ini" name="tanggal_mulai_kerja_instansi_saat_ini" 
                                   value="{{ old('tanggal_mulai_kerja_instansi_saat_ini', $tracerStudy->tanggal_mulai_kerja_instansi_saat_ini ?? '') }}"
                                   required>
                            @error('tanggal_mulai_kerja_instansi_saat_ini')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="instansi_id">Instansi <span class="text-danger">*</span></label>
                            <select class="form-control @error('instansi_id') is-invalid @enderror" id="instansi_id" name="instansi_id" required>
                                <option value="">Pilih Instansi</option>
                                @foreach ($instansi as $item)
                                    <option value="{{ $item->instansi_id }}" 
                                            {{ old('instansi_id', $tracerStudy->instansi_id ?? '') == $item->instansi_id ? 'selected' : '' }}>
                                        {{ $item->nama_instansi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instansi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kategori_profesi_id">Kategori Profesi <span class="text-danger">*</span></label>
                            <select class="form-control @error('kategori_profesi_id') is-invalid @enderror" id="kategori_profesi_id" name="kategori_profesi_id" required>
                                <option value="">Pilih Kategori Profesi</option>
                                @foreach ($kategoriProfesi as $item)
                                    <option value="{{ $item->kategori_id }}" 
                                            {{ old('kategori_profesi_id', $tracerStudy->kategori_profesi_id ?? '') == $item->kategori_id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_profesi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="profesi_id">Profesi <span class="text-danger">*</span></label>
                            <select class="form-control @error('profesi_id') is-invalid @enderror" id="profesi_id" name="profesi_id" required>
                                <option value="">Pilih Profesi</option>
                                @foreach ($profesi as $item)
                                    <option value="{{ $item->profesi_id }}" 
                                            {{ old('profesi_id', $tracerStudy->profesi_id ?? '') == $item->profesi_id ? 'selected' : '' }}>
                                        {{ $item->nama_profesi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('profesi_id')
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
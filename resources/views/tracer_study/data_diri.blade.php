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

                    <form action="{{ route('tracer-study.store-data-diri') }}" method="POST" id="dataDiriForm">
                        @csrf
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" id="nim" value="{{ $alumni->nim ?? '' }}" disabled>
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

                       <!-- Pilihan Instansi -->
<div class="form-group">
    <label>Instansi <span class="text-danger">*</span></label>
    <div class="row">
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pilihan_instansi" id="pilih_existing" value="existing" checked>
                <label class="form-check-label" for="pilih_existing">
                    Pilih dari daftar yang tersedia
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pilihan_instansi" id="pilih_baru" value="baru">
                <label class="form-check-label" for="pilih_baru">
                    Tambahkan instansi baru
                </label>
            </div>
        </div>
    </div>
    @error('instansi')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>


                        <!-- Dropdown Instansi Existing -->
                        <div class="form-group" id="instansi_existing_group">
                            <label for="instansi_id">Pilih Instansi</label>
                            <select class="form-control @error('instansi_id') is-invalid @enderror" id="instansi_id" name="instansi_id">
                                <option value="">Pilih Instansi</option>
                                @foreach ($instansi as $item)
                                    <option value="{{ $item->instansi_id }}" 
                                            {{ old('instansi_id', $tracerStudy->instansi_id ?? '') == $item->instansi_id ? 'selected' : '' }}>
                                        {{ $item->nama_instansi }} - {{ $item->jenis_instansi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instansi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Instansi Baru -->
                        <div id="instansi_baru_group" style="display: none;">
                            <div class="form-group">
                                <label for="instansi_baru">Nama Instansi Baru</label>
                                <input type="text" class="form-control @error('instansi_baru') is-invalid @enderror" 
                                       id="instansi_baru" name="instansi_baru" 
                                       value="{{ old('instansi_baru') }}"
                                       placeholder="Masukkan nama instansi">
                                @error('instansi_baru')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="jenis_instansi">Jenis Instansi</label>
                                <select class="form-control @error('jenis_instansi') is-invalid @enderror" 
                                        id="jenis_instansi" name="jenis_instansi">
                                    <option value="">Pilih Jenis Instansi</option>
                                    <option value="Pendidikan Tinggi" {{ old('jenis_instansi') == 'Pendidikan Tinggi' ? 'selected' : '' }}>Pendidikan Tinggi</option>
                                    <option value="Pemerintah" {{ old('jenis_instansi') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                    <option value="Swasta" {{ old('jenis_instansi') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                    <option value="BUMN" {{ old('jenis_instansi') == 'BUMN' ? 'selected' : '' }}>BUMN</option>
                                </select>
                                @error('jenis_instansi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="skala">Skala Instansi</label>
                                <select class="form-control @error('skala') is-invalid @enderror" 
                                        id="skala" name="skala">
                                    <option value="">Pilih Skala</option>
                                    <option value="nasional" {{ old('skala') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="internasional" {{ old('skala') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                    <option value="wirausaha" {{ old('skala') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                </select>
                                @error('skala')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="lokasi">Lokasi Instansi</label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                       id="lokasi" name="lokasi" 
                                       value="{{ old('lokasi') }}"
                                       placeholder="Contoh: Jakarta, Indonesia">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="no_hp_instansi">No. HP Instansi (Opsional)</label>
                                <input type="text" class="form-control @error('no_hp_instansi') is-invalid @enderror" 
                                       id="no_hp_instansi" name="no_hp_instansi" 
                                       value="{{ old('no_hp_instansi') }}"
                                       placeholder="Contoh: 021-12345678">
                                @error('no_hp_instansi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pilihExisting = document.getElementById('pilih_existing');
    const pilihBaru = document.getElementById('pilih_baru');
    const instansiExistingGroup = document.getElementById('instansi_existing_group');
    const instansiBaruGroup = document.getElementById('instansi_baru_group');
    const instansiSelect = document.getElementById('instansi_id');
    const instansiBaruInput = document.getElementById('instansi_baru');
    const jenisInstansiSelect = document.getElementById('jenis_instansi');
    const skalaSelect = document.getElementById('skala');
    const lokasiInput = document.getElementById('lokasi');
    const form = document.getElementById('dataDiriForm');

    function toggleInstansiForm() {
        if (pilihExisting.checked) {
            instansiExistingGroup.style.display = 'block';
            instansiBaruGroup.style.display = 'none';
            
            // Reset form instansi baru
            instansiBaruInput.value = '';
            jenisInstansiSelect.value = '';
            skalaSelect.value = '';
            lokasiInput.value = '';
            
            // Set required
            instansiSelect.required = true;
            instansiBaruInput.required = false;
            jenisInstansiSelect.required = false;
            skalaSelect.required = false;
            lokasiInput.required = false;
        } else {
            instansiExistingGroup.style.display = 'none';
            instansiBaruGroup.style.display = 'block';
            
            // Reset dropdown instansi
            instansiSelect.value = '';
            
            // Set required
            instansiSelect.required = false;
            instansiBaruInput.required = true;
            jenisInstansiSelect.required = true;
            skalaSelect.required = true;
            lokasiInput.required = true;
        }
    }

    pilihExisting.addEventListener('change', toggleInstansiForm);
    pilihBaru.addEventListener('change', toggleInstansiForm);

    // Validasi sebelum submit
    form.addEventListener('submit', function(event) {
        if (pilihExisting.checked && !instansiSelect.value) {
            event.preventDefault();
            alert('Harap pilih instansi dari daftar yang tersedia.');
            instansiSelect.focus();
            return false;
        }
        if (pilihBaru.checked && !instansiBaruInput.value) {
            event.preventDefault();
            alert('Harap masukkan nama instansi baru.');
            instansiBaruInput.focus();
            return false;
        }
    });

    // Inisialisasi tampilan berdasarkan pilihan saat ini
    toggleInstansiForm();

    // Jika ada error dan pilihan instansi baru dipilih, tampilkan form yang sesuai
    @if(old('pilihan_instansi') == 'baru' || old('instansi_baru'))
        pilihBaru.checked = true;
        toggleInstansiForm();
    @endif
});
</script>
@endsection
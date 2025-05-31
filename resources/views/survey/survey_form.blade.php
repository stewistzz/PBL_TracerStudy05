@extends('layouts.template')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Survei Pengguna Lulusan</h4>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5 class="text-muted">Informasi Alumni</h5>
                <p class="mb-1"><strong>Nama:</strong> {{ $alumni->nama }}</p>
                <p class="mb-1"><strong>Program Studi:</strong> {{ $alumni->program_studi }}</p>
                <p class="mb-1"><strong>Tahun Lulus:</strong> {{ $alumni->tahun_lulus }}</p>
                <p class="mb-1"><strong>Tahun Lulus:</strong> {{ \Carbon\Carbon::parse($alumni->tahun_lulus)->year }}</p>

            </div>

            <div class="mb-4">
                <h5 class="text-muted">Pengisi Survei</h5>
                <p class="mb-1"><strong>Nama:</strong> {{ $pengguna->nama }}</p>
                <p class="mb-1"><strong>Instansi:</strong> {{ $pengguna->instansi }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $pengguna->email }}</p>
            </div>

            <form action="{{ route('survey.submit', $token) }}" method="POST">
                @csrf
                @foreach ($pertanyaan as $p)
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ $p->isi_pertanyaan }}</label>

                        @if ($p->jenis_pertanyaan == 'isian')
                            <input type="text" name="jawaban[{{ $p->pertanyaan_id }}]" class="form-control" required>

                        @elseif ($p->jenis_pertanyaan == 'pilihan_ganda')
                            @foreach ($p->opsiPilihan as $opsi)
                                <div class="form-check">
                                    <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" value="{{ $opsi->teks_opsi }}" class="form-check-input" required>
                                    <label class="form-check-label">{{ $opsi->teks_opsi }}</label>
                                </div>
                            @endforeach

                        @elseif ($p->jenis_pertanyaan == 'skala')
                            <select name="jawaban[{{ $p->pertanyaan_id }}]" class="form-select" required>
                                <option value="">Pilih skala</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>

                        @elseif ($p->jenis_pertanyaan == 'ya_tidak')
                            <div class="form-check form-check-inline">
                                <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" value="Ya" class="form-check-input" required>
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" value="Tidak" class="form-check-input" required>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        @endif

                        @error('jawaban.' . $p->pertanyaan_id)
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success">Kirim Jawaban</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.template')

@section('content')
    <div class="container">
        <h1>Survei untuk Alumni: {{ $alumni->nama }}</h1>
        <p>Pengisi: {{ $pengguna->nama }} ({{ $pengguna->instansi }})</p>
        <form action="{{ route('survey.submit', $token) }}" method="POST">
            @csrf
            @foreach ($pertanyaan as $p)
                <div class="mb-3">
                    <label class="form-label">{{ $p->isi_pertanyaan }}</label>
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
                        <div class="form-check">
                            <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" value="Ya" class="form-check-input" required>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" value="Tidak" class="form-check-input" required>
                            <label class="form-check-label">Tidak</label>
                        </div>
                    @endif
                    @error('jawaban.' . $p->pertanyaan_id)
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
        </form>
    </div>
@endsection
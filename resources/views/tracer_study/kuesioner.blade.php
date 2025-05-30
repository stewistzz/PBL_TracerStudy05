@extends('layouts.template')

@section('content')
<div class="content-wrapper py-4">
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="mb-3">Kuesioner Alumni</h2>
        <p class="mb-4">Silakan isi kuesioner di bawah ini sesuai pengalaman Anda.</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($pertanyaan->isEmpty())
            <div class="alert alert-warning">Belum ada pertanyaan kuesioner tersedia.</div>
            <a href="{{ route('tracer-study.index') }}" class="btn btn-secondary">Kembali</a>
        @else
            <form action="{{ route('tracer-study.store-kuesioner') }}" method="POST">
                @csrf
                @foreach ($pertanyaan as $index => $p)
                    @php $existing = $jawabanExisting[$p->pertanyaan_id] ?? null; @endphp

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            {{ $index + 1 }}. {{ ucfirst($p->isi_pertanyaan) }}
                            @if ($p->wajib) <span class="text-danger">*</span> @endif
                        </label>

                        @if ($p->jenis_pertanyaan == 'isian')
                            <input type="text"
                                name="jawaban[{{ $p->pertanyaan_id }}]"
                                class="form-control @error('jawaban.' . $p->pertanyaan_id) is-invalid @enderror"
                                value="{{ old('jawaban.' . $p->pertanyaan_id, $existing) }}"
                                {{ $p->wajib ? 'required' : '' }}>
                        @elseif ($p->jenis_pertanyaan == 'pilihan_ganda')
                            @foreach ($p->opsiPilihan as $opsi)
                                <div class="form-check">
                                    <input type="radio"
                                        name="jawaban[{{ $p->pertanyaan_id }}]"
                                        value="{{ $opsi->teks_opsi }}"
                                        class="form-check-input"
                                        id="opsi_{{ $p->pertanyaan_id }}_{{ $opsi->id }}"
                                        {{ $existing == $opsi->teks_opsi ? 'checked' : '' }}
                                        {{ $p->wajib ? 'required' : '' }}>
                                    <label class="form-check-label" for="opsi_{{ $p->pertanyaan_id }}_{{ $opsi->id }}">
                                        {{ $opsi->teks_opsi }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif ($p->jenis_pertanyaan == 'skala')
                            <select name="jawaban[{{ $p->pertanyaan_id }}]"
                                    class="form-select @error('jawaban.' . $p->pertanyaan_id) is-invalid @enderror"
                                    {{ $p->wajib ? 'required' : '' }}>
                                <option value="">Pilih skala</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $existing == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        @elseif ($p->jenis_pertanyaan == 'ya_tidak')
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input"
                                       name="jawaban[{{ $p->pertanyaan_id }}]"
                                       value="Ya"
                                       id="ya_{{ $p->pertanyaan_id }}"
                                       {{ $existing == 'Ya' ? 'checked' : '' }} {{ $p->wajib ? 'required' : '' }}>
                                <label class="form-check-label" for="ya_{{ $p->pertanyaan_id }}">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input"
                                       name="jawaban[{{ $p->pertanyaan_id }}]"
                                       value="Tidak"
                                       id="tidak_{{ $p->pertanyaan_id }}"
                                       {{ $existing == 'Tidak' ? 'checked' : '' }} {{ $p->wajib ? 'required' : '' }}>
                                <label class="form-check-label" for="tidak_{{ $p->pertanyaan_id }}">Tidak</label>
                            </div>
                        @endif

                        @error('jawaban.' . $p->pertanyaan_id)
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                    <a href="{{ route('tracer-study.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

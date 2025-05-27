@extends('layouts.template')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kuesioner Alumni</h4>
                    <p class="card-description">Jawab pertanyaan berikut terkait pengalaman kerja Anda.</p>
                    
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

                    @if ($pertanyaan->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Belum ada pertanyaan kuesioner yang tersedia. Silakan hubungi admin untuk informasi lebih lanjut.
                        </div>
                        <a href="{{ route('tracer-study.index') }}" class="btn btn-secondary">Kembali</a>
                    @else
                        <form action="{{ route('tracer-study.store-kuesioner') }}" method="POST">
                            @csrf
                            @foreach ($pertanyaan as $index => $item)
                                <div class="form-group">
                                    <label for="jawaban_{{ $item->pertanyaan_id }}">
                                        {{ $index + 1 }}. {{ $item->isi_pertanyaan }}
                                        @if ($item->wajib)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    @if ($item->tipe === 'pilihan_ganda')
                                        @foreach ($item->opsiPilihan as $opsi)
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" 
                                                       name="jawaban[{{ $item->pertanyaan_id }}]" 
                                                       id="opsi_{{ $item->pertanyaan_id }}_{{ $opsi->id }}" 
                                                       value="{{ $opsi->teks_opsi }}"
                                                       {{ isset($jawabanExisting[$item->pertanyaan_id]) && $jawabanExisting[$item->pertanyaan_id] === $opsi->teks_opsi ? 'checked' : '' }}
                                                       {{ $item->wajib ? 'required' : '' }}>
                                                <label class="form-check-label" for="opsi_{{ $item->pertanyaan_id }}_{{ $opsi->id }}">
                                                    {{ $opsi->teks_opsi }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @error("jawaban.{$item->pertanyaan_id}")
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    @elseif ($item->tipe === 'checkbox')
                                        @foreach ($item->opsiPilihan as $opsi)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" 
                                                       name="jawaban[{{ $item->pertanyaan_id }}][]" 
                                                       id="opsi_{{ $item->pertanyaan_id }}_{{ $opsi->id }}" 
                                                       value="{{ $opsi->teks_opsi }}"
                                                       {{ isset($jawabanExisting[$item->pertanyaan_id]) && in_array($opsi->teks_opsi, explode(', ', $jawabanExisting[$item->pertanyaan_id])) ? 'checked' : '' }}
                                                       {{ $item->wajib ? 'required' : '' }}>
                                                <label class="form-check-label" for="opsi_{{ $item->pertanyaan_id }}_{{ $opsi->id }}">
                                                    {{ $opsi->teks_opsi }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @error("jawaban.{$item->pertanyaan_id}")
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    @else
                                        <textarea class="form-control @error("jawaban.{$item->pertanyaan_id}") is-invalid @enderror" 
                                                  name="jawaban[{{ $item->pertanyaan_id }}]" 
                                                  id="jawaban_{{ $item->pertanyaan_id }}" 
                                                  rows="4" {{ $item->wajib ? 'required' : '' }}>{{ old("jawaban.{$item->pertanyaan_id}", $jawabanExisting[$item->pertanyaan_id] ?? '') }}</textarea>
                                        @error("jawaban.{$item->pertanyaan_id}")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Simpan dan Selesaikan</button>
                            <a href="{{ route('tracer-study.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
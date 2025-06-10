@extends('layouts.template')

@section('content')
<style>
    .survey-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    .survey-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .card-header {
        background: #007bff;
        color: #ffffff;
        padding: 20px;
        font-size: 1.5rem;
        font-weight: 600;
        text-align: center;
        border-bottom: 2px solid #0056b3;
    }
    .card-body {
        padding: 35px;
    }
    .info-section {
        display: flex;
        justify-content: space-between;
        margin-bottom: 35px;
        gap: 20px;
    }
    .info-card {
        background: #fafafa;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        width: 48%;
    }
    .info-card h5 {
        font-size: 1.1rem;
        color: #1a252f;
        margin-bottom: 15px;
        border-bottom: 1px solid #d0d0d0;
        padding-bottom: 8px;
        font-weight: 500;
    }
    .info-card p {
        margin: 8px 0;
        font-size: 0.95rem;
        color: #4a4a4a;
    }
    .form-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 30px;
    }
    .form-table th, .form-table td {
        padding: 18px;
        text-align: left;
        border-bottom: 1px solid #e5e5e5;
        vertical-align: top;
    }
    .form-table th {
        background: #f5f6fa;
        font-weight: 600;
        color: #1a252f;
        width: 35%;
        font-size: 0.95rem;
    }
    .form-table td {
        background: #ffffff;
    }
    .form-control, .form-select {
        border: 1px solid #b0b7c0;
        border-radius: 6px;
        padding: 10px 12px;
        width: 100%;
        font-size: 0.95rem;
        color: #1a252f;
        background: #ffffff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 6px rgba(0, 123, 255, 0.15);
    }
    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .form-check-input {
        margin-right: 12px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }
    .form-check-label {
        font-size: 0.95rem;
        color: #1a252f;
        cursor: pointer;
    }
    .radio-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .btn-submit {
        background: #007bff;
        color: #ffffff;
        border: none;
        padding: 12px 50px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        display: block;
        margin: 0 auto;
    }
    .btn-submit:hover {
        background: #0056b3;
    }
    .text-danger {
        font-size: 0.85rem;
        color: #d32f2f;
        margin-top: 6px;
        display: block;
    }
</style>

<div class="survey-container">
    <div class="survey-card">
        <div class="card-header">
            Form Survei Pengguna Lulusan
        </div>
        <div class="card-body">
            <div class="info-section">
                <div class="info-card">
                    <h5>Informasi Alumni</h5>
                    <p><strong>Nama:</strong> {{ $alumni->nama }}</p>
                    <p><strong>Program Studi:</strong> {{ $alumni->program_studi }}</p>
                    <p><strong>Tahun Lulus:</strong> {{ \Carbon\Carbon::parse($alumni->tahun_lulus)->year }}</p>
                </div>
                <div class="info-card">
                    <h5>Informasi Pengisi Survei</h5>
                    <p><strong>Nama:</strong> {{ $pengguna->nama }}</p>
                    <p><strong>Instansi:</strong> {{ $pengguna->instansi }}</p>
                    <p><strong>Email:</strong> {{ $pengguna->email }}</p>
                </div>
            </div>

            <form action="{{ route('survey.submit', $token) }}" method="POST">
                @csrf
                <table class="form-table">
                    <tbody>
                        @foreach ($pertanyaan as $index => $p)
                            <tr>
                                <th>{{ $index + 1 }}. {{ $p->isi_pertanyaan }}</th>
                                <td>
                                    @if ($p->jenis_pertanyaan == 'isian')
                                        <input type="text" name="jawaban[{{ $p->pertanyaan_id }}]" 
                                               class="form-control" required>
                                    @elseif ($p->jenis_pertanyaan == 'pilihan_ganda')
                                        <div class="radio-group">
                                            @foreach ($p->opsiPilihan as $opsi)
                                                <div class="form-check">
                                                    <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" 
                                                           value="{{ $opsi->teks_opsi }}" 
                                                           class="form-check-input" required>
                                                    <label class="form-check-label">{{ $opsi->teks_opsi }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif ($p->jenis_pertanyaan == 'skala')
                                        <select name="jawaban[{{ $p->pertanyaan_id }}]" class="form-select" required>
                                            <option value="">Pilih skala</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }} - {{ $i == 1 ? 'Sangat Buruk' : ($i == 2 ? 'Buruk' : ($i == 3 ? 'Netral' : ($i == 4 ? 'Baik' : 'Sangat Baik'))) }}</option>
                                            @endfor
                                        </select>
                                    @elseif ($p->jenis_pertanyaan == 'ya_tidak')
                                        <div class="radio-group">
                                            <div class="form-check">
                                                <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" 
                                                       value="Ya" class="form-check-input" required>
                                                <label class="form-check-label">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="jawaban[{{ $p->pertanyaan_id }}]" 
                                                       value="Tidak" class="form-check-input" required>
                                                <label class="form-check-label">Tidak</label>
                                            </div>
                                        </div>
                                    @endif

                                    @error('jawaban.' . $p->pertanyaan_id)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn-submit">Kirim Jawaban</button>
            </form>
        </div>
    </div>
</div>
@endsection
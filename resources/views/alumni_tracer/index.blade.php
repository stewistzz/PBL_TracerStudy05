@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Data Tracer Study</h4>
        <p class="card-description">Daftar tracer alumni</p>

        {{-- <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-primary" id="btn-tambah">Tambah Data</button>
        </div> --}}

        <div class="table-responsive">
            <table class="table table-bordered" id="tracer-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alumni</th>
                        <th>Instansi</th>
                        <th>Kategori Profesi</th>
                        <th>Profesi</th>
                        <th>Tanggal Pengisian</th>
                        <th>Tgl Pertama Kerja</th>
                        <th>Tgl Mulai Instansi Sekarang</th>
                        <th>Nama Atasan</th>
                        <th>Jabatan Atasan</th>
                        <th>No HP Atasan</th>
                        <th>Email Atasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
{{-- <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- AJAX-loaded form goes here -->
        </div>
    </div>
</div> --}}
@endsection

@push('js')
<script>
$(document).ready(function () {
    $('#tracer-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('alumni_tracer.list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'alumni', name: 'alumni.nama' },
            { data: 'instansi', name: 'instansi.nama_instansi' },
            { data: 'kategori_profesi', name: 'kategoriProfesi.nama_kategori' },
            { data: 'profesi', name: 'profesi.nama_profesi' },
            { data: 'tanggal_pengisian', name: 'tanggal_pengisian' },
            { data: 'tanggal_pertama_kerja', name: 'tanggal_pertama_kerja' },
            { data: 'tanggal_mulai_kerja_instansi_saat_ini', name: 'tanggal_mulai_kerja_instansi_saat_ini' },
            { data: 'nama_atasan', name: 'nama_atasan_langsung' },
            { data: 'jabatan_atasan', name: 'jabatan_atasan_langsung' },
            { data: 'no_hp_atasan', name: 'no_hp_atasan_langsung' },
            { data: 'email_atasan', name: 'email_atasan_langsung' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    
});
</script>
@endpush

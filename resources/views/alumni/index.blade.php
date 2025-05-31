@extends('layouts.template')
    <link rel="stylesheet" href="{{ asset('skydash/template/css/styletambah.css') }}">

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold">Data Alumni</h3>
            <hr>
            <p class="card-description">
                Kelola data alumni dengan mudah untuk mendukung pencatatan lulusan, pelacakan karier, dan evaluasi hasil
                pendidikan. Fitur ini memungkinkan Anda menambahkan, mengedit, dan menghapus data alumni sesuai kebutuhan,
                sehingga mempermudah pengelolaan informasi alumni secara terstruktur dan efisien.
            </p>
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-info d-flex align-items-center gap-1" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i>
                    Tambah Alumni
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table" id="alumni-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Program Studi</th>
                            <th>Tahun Lulus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    {{-- Tidak perlu <tfoot> jika total tidak ditampilkan di footer --}}
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{-- Konten form (create/edit) akan di‐load via AJAX --}}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Fungsi untuk reload DataTable dari luar (bisa dipanggil setelah store/update/destroy)
        window.loadTable = function() {
            $('#alumni-table').DataTable().ajax.reload(null, false);
        };

        $(document).ready(function() {
            let table = $('#alumni-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('alumni.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username', // Nama kolom yang dikirim dari controller (addColumn('user_name', …))
                        name: 'username' // Untuk keperluan sorting/search di relasi User
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nim',
                        name: 'nim'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'program_studi',
                        name: 'program_studi'
                    },
                    {
                        data: 'tahun_lulus_formatted', // Misalnya controller mengirimkan field ini
                        name: 'tahun_lulus'
                    },
                    {
                        data: 'action', // Tombol Edit & Hapus (dikirim oleh controller)
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Tombol Tambah → load form create via AJAX
            $('#btn-tambah').on('click', function() {
                $.get('{{ route('alumni.create') }}', function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Edit → load form edit via AJAX
            $('#alumni-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                let url = '{{ route('alumni.edit', ':id') }}'.replace(':id', id);

                $.get(url, function(res) {
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Hapus → kirim DELETE via AJAX
            $('#alumni-table').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                if (!confirm("Yakin ingin menghapus data ini?")) return;

                let url = '{{ route('alumni.destroy', ':id') }}'.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        table.ajax.reload(null, false);
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(err) {
                        console.error('Delete Error:', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal menghapus data!'
                        });
                    }
                });
            });
        });
    </script>
@endpush

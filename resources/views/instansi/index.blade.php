@extends('layouts.template')

<link rel="stylesheet" href="{{ asset('skydash/template/css/styletambah.css') }}">



@section('content')
    <!-- Row: Pie Chart dan Detail Instansi -->
    <div class="row">
        <!-- Card: Pie Chart Jenis Instansi -->
        <div class="col-lg-4 mb-4">
            <div class="card rounded-4">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold mb-4">Sebaran Jenis Instansi</h4>
                    <canvas id="instansiChart" width="240" height="240"></canvas>
                </div>
            </div>
        </div>

        <!-- Card: Detail Instansi -->
        <div class="col-lg-8">
            <div class="card rounded-4 shadow-sm h-100 p-4">
                <h2 class="fw-bold mb-3 text-dark">Detail Sebaran Instansi Alumni</h2>
                <h2><b style="color: rgb(30, 161, 201);">Politeknik Negeri Malang</b></h2>

                <div class="my-4">
                    <h1 class="display-3 fw-black text-dark">{{ $instansiData->sum('total') }}</h1>
                    <h5>Total Alumni Berdasarkan Instansi</h5>
                </div>

                <p class="text-muted fs-10 text-justify">
                    Grafik ini menampilkan data sebaran alumni
                    <span class="fw-semibold text-dark">Politeknik Negeri Malang</span>
                    berdasarkan jenis instansi tempat mereka bekerja, seperti Pemerintah, Swasta, BUMN,
                    maupun Pendidikan Tinggi. Informasi ini membantu institusi memahami orientasi karier lulusan
                    serta meningkatkan kerja sama strategis dengan berbagai sektor kerja.
                </p>
            </div>
        </div>
    </div>

    <!-- Card: Tabel Data Instansi -->
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Data Instansi</h4>
            <p class="card-description">Kelola data instansi dengan mudah</p>

            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-info d-flex align-items-center gap-1" id="btn-tambah">
                    <i class="mdi mdi-plus-circle-outline fs-5 mr-2"></i>
                    Tambah Instansi
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table" id="instansi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Instansi</th>
                            <th>Jenis</th>
                            <th>Skala</th>
                            <th>Lokasi</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Form Tambah/Edit/Hapus Instansi -->
    <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Akan diisi melalui AJAX -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        window.loadTable = function() {
            $('#instansi-table').DataTable().ajax.reload();
        };

        $(document).ready(function() {
            let table = $('#instansi-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('instansi.list') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_instansi',
                        name: 'nama_instansi'
                    },
                    {
                        data: 'jenis_instansi',
                        name: 'jenis_instansi'
                    },
                    {
                        data: 'skala',
                        name: 'skala'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Tombol Tambah
            $('#btn-tambah').click(function() {
                $.get('{{ route('instansi.create') }}', function(res) {
                    console.log('Create Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Edit
            $('#instansi-table').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get('{{ route('instansi.edit', ':id') }}'.replace(':id', id), function(res) {
                    console.log('Edit Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });

            // Tombol Hapus
            $('#instansi-table').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                $.get('{{ route('instansi.confirm', ':id') }}'.replace(':id', id), function(res) {
                    console.log('Confirm Delete Response:', res);
                    $('#modal-form .modal-content').html(res);
                    $('#modal-form').modal('show');
                });
            });
        });
    </script>

    {{-- Script Pie Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const instansiCtx = document.getElementById('instansiChart').getContext('2d');

        const instansiChart = new Chart(instansiCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($instansiData->pluck('jenis_instansi')) !!},
                datasets: [{
                    label: 'Sebaran Jenis Instansi Alumni',
                    data: {!! json_encode($instansiData->pluck('total')) !!},
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#66BB6A', '#EF5350'
                    ],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value} orang`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
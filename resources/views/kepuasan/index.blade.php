@extends('layouts.template')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>Tingkat Kepuasan Pengguna</title>
        <!-- Bootstrap & DataTables CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
        <style>
            th,
            td {
                text-align: center;
                vertical-align: middle;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h3 class="mb-4 text-center">Tingkat Kepuasan Pengguna (%)</h3>

            <table id="tabelKemampuan" class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Jenis Kemampuan</th>
                        <th>Sangat Baik</th>
                        <th>Baik</th>
                        <th>Cukup</th>
                        <th>Kurang</th>
                    </tr>
                </thead>
                <tfoot class="table-secondary fw-bold">
                    <tr>
                        <td colspan="2">Jumlah</td>
                        <td>39.85%</td>
                        <td>48.72%</td>
                        <td>8.20%</td>
                        <td>3.23%</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-12 grid-margin stretch-card mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Alumni Belum Mengisi Tracer Study</h4>
                    <p class="card-description text-muted">Berikut ini adalah alumni yang belum mengisi tracer study
                        POLINEMA</p>
                    
                    {{-- export --}}
                    <a href="{{ route('pengguna_kepuasan.export_belum_isi') }}" class="btn btn-warning btn-sm">
    <i class="mdi mdi-file-excel"></i> Export ke Excel
</a>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                    
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="survey-table-belum-isi">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Instansi</th>
                                    <th>Jabatan</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <!-- JQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabelKemampuan').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/kemampuan/list') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'sangat_baik',
                        name: 'sangat_baik'
                    },
                    {
                        data: 'baik',
                        name: 'baik'
                    },
                    {
                        data: 'cukup',
                        name: 'cukup'
                    },
                    {
                        data: 'kurang',
                        name: 'kurang'
                    }
                ],
                paging: false,
                searching: false,
                ordering: false,
                info: false,
            });
            
        });
    </script>
    <script>
    $(document).ready(function () {
        $('#survey-table-belum-isi').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pengguna_kepuasan.belum_isi') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
                { data: 'instansi', name: 'instansi' },
                { data: 'jabatan', name: 'jabatan' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status', orderable: false, searchable: false }
            ]
        });
    });
</script>

</body>

</html>

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
</body>

</html>
